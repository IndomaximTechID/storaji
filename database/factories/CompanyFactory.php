<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'name' => $faker->name,
        'user_id' => \App\User::first(),
        'type_id' => \App\CompanyType::first()
    ];
});
