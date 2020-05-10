<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "other_names" => $faker->lastName,
        "email" => $faker->email,
        "phone_number" => $faker->phoneNumber,
        "birth_date" => $faker->date('d-m-Y'),
        "company" => $faker->company,
    ];
});
