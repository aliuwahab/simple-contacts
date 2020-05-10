<?php

namespace Tests\Feature;

use App\Contact;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_contact_can_be_added()
    {
        $data = $this->data();

        $this->post(route('api.contacts.store'), $data);

        $contact = Contact::first();

        $this->assertEquals($data['first_name'], $contact->first_name);
        $this->assertEquals($data['phone_number'], $contact->phone_number);
        $this->assertEquals($data['email'], $contact->email);
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
    public function can_get_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $response = $this->get(route('api.contact.show', $contact->id));

        $response->assertJson(
            [
                "first_name" => $contact->first_name,
                "last_name" => $contact->last_name,
                "other_names" => $contact->other_names,
                "email" => $contact->email,
                "phone_number" => $contact->phone_number,
                "company" => $contact->company,
            ]
        );
    }


    /** @test */
    public function can_update_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $data = $this->data();

        $this->patch(route('api.contact.update', $contact->id), $data);

        $contact = $contact->fresh();

        $this->assertEquals($data['first_name'], $contact->first_name);
        $this->assertEquals($data['phone_number'], $contact->phone_number);
        $this->assertEquals($data['email'], $contact->email);
    }


    /** @test */
    public function can_delete_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $this->delete(route('api.contact.destroy', $contact->id));

        $this->assertDatabaseCount('contacts', 0);
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
            "birth_date" => "07/11/2018"
        ];

        return $data;
    }

}
