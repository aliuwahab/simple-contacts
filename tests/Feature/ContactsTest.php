<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function an_un_authenticated_user_should_be_redirected_to_login()
    {
        $data = $this->data();

        $response = $this->post(route('api.contacts.store'), array_merge($data, ['api_token' => '']));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function an_authenticated_user_can_add_a_contact()
    {
        $data = $this->data();

        $response = $this->post(route('api.contacts.store'), $data);

        $contact = Contact::first();

        $this->assertEquals($data['first_name'], $contact->first_name);
        $this->assertEquals($data['phone_number'], $contact->phone_number);
        $this->assertEquals($data['email'], $contact->email);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(
            [
                'data' => ['contact_id' => $contact->id],
                'links' => ['self' => $contact->path()]
            ]
        );
    }


    /** @test */
    public function test_first_name_is_required()
    {
        $response = $this->post(route('api.contacts.store'), array_merge($this->data(), ['first_name' => '']));

        $response->assertSessionHasErrors('first_name');

        $this->assertDatabaseCount('contacts', 0);
    }


    /** @test */
    public function test_last_name_is_required()
    {
        $response = $this->post(route('api.contacts.store'), array_merge($this->data(), ['last_name' => '']));

        $response->assertSessionHasErrors('last_name');

        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function test_email_is_required()
    {
        $response = $this->post(route('api.contacts.store'), array_merge($this->data(), ['email' => '']));

        $response->assertSessionHasErrors('email');

        $this->assertDatabaseCount('contacts', 0);
    }


    /** @test */
    public function test_birth_date_is_required()
    {
        $response = $this->post(route('api.contacts.store'), array_merge($this->data(), ['birth_date' => '']));

        $response->assertSessionHasErrors('birth_date');

        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function birth_date_are_saved_properly()
    {
        $data = $this->data();

        $this->post(route('api.contacts.store'), $data);

        $contact = Contact::first();

        $this->assertEquals($data['first_name'], $contact->first_name);
        $this->assertEquals($data['phone_number'], $contact->phone_number);
        $this->assertEquals($data['email'], $contact->email);

        $contact = Contact::first();

        $this->assertInstanceOf(Carbon::class, $contact->birth_date);
    }


    /** @test */
    public function an_authenticated_user_can_get_a_contact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

//        $response = $this->get(route('api.contact.show', $contact->id, ['api_token' => $this->user->api_token])); TODO:: Figure out how to use route name for get with query strings
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $this->user->api_token);

        $response->assertJson(
            [
                'data' => [
                    'contact_id' => $contact->id,
                    'full_name' => $contact->first_name . ' ' . $contact->other_names . ' ' . $contact->last_name,
                    "email" => $contact->email,
                    "phone_number" => $contact->phone_number,
                    "company" => $contact->company,
                ]
            ]
        );
    }


    /** @test */
    public function an_authenticated_user_can_get_only_their_contact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $anotherUser = factory(User::class)->create();

//        $response = $this->get(route('api.contact.show', $contact->id, ['api_token' => $this->user->api_token])); TODO:: Figure out how to use route name for get with query strings
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $anotherUser->api_token);

        $response->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_update_a_contact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $data = $this->data();

        $response = $this->patch(route('api.contact.update', $contact->id), $data);

        $contact = $contact->fresh();

        $this->assertEquals($data['first_name'], $contact->first_name);
        $this->assertEquals($data['phone_number'], $contact->phone_number);
        $this->assertEquals($data['email'], $contact->email);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            [
                'data' => ['contact_id' => $contact->id],
                'links' => ['self' => $contact->path()]
            ]
        );
    }


    /** @test */
    public function only_the_owner_of_a_contact_can_update_it()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $data = $this->data();

        $response = $this->patch(
            route('api.contact.update', $contact->id),
            array_merge($data, ['api_token' => $anotherUser->api_token])
        );

        $response->assertStatus(403);
    }

    /** @test */
    public function can_delete_a_contact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('api.contact.destroy', $contact->id), ['api_token' => $this->user->api_token]);

        $this->assertDatabaseCount('contacts', 0);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_the_owner_can_delete_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete(route('api.contact.destroy', $contact->id), ['api_token' => $anotherUser->api_token]);

        $response->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_get_their_the_list_of_their_contacts()
    {
        $firstUser = factory(User::class)->create();
        $secondUser = factory(User::class)->create();

        $firstUserContact = factory(Contact::class)->create(['user_id' => $firstUser->id]);
        factory(Contact::class)->create(['user_id' => $secondUser->id]);

        //$response = $this->get(route('api.contacts', $contact->id, ['api_token' => $this->user->api_token])); TODO:: Figure out how to use route name for get with query strings
        $response = $this->get('/api/contacts/?api_token=' . $firstUser->api_token);

        $response->assertJsonCount(1)->assertJson(
            [
                'data' => [
                    [
                        'data' => ['contact_id' => $firstUserContact->id]

                    ]
                ]
            ]
        );
    }


    /**
     * @return array
     */
    public function data(): array
    {
        $data = [
            "first_name" => "Faiq Nyu-Sung",
            "last_name" => "Aliu",
            "email" => "faiq@gmail.com",
            "phone_number" => "0684442593",
            "birth_date" => "07/11/2018",
            "api_token" => $this->user->api_token
        ];

        return $data;
    }

}
