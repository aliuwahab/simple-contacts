<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BirthDaysTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function contact_with_birth_days_in_current_month_can_be_fetched()
    {
        $user = factory(User::class)->create();

        $birthDayContacts = factory(Contact::class)->create(
            [
                'user_id' => $user->id,
                'birth_date' => now()->subYear(),
            ]
        );


        $noBirthDayContacts = factory(Contact::class)->create(
            [
                'user_id' => $user->id,
                'birth_date' => now()->subMonth(),
            ]
        );

        $this->get('/api/birthdays?api_token='.$user->api_token)->assertJsonCount(1)->assertJson(
            [
                'data' => [
                    [
                        'data' => ['contact_id' => $birthDayContacts->id]

                    ]
                ]
            ]
        );
    }
}
