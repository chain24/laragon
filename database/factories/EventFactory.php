<?php

use Faker\Generator as Faker;
use App\Models\School;
use App\User;

$factory->define(\App\Models\Event::class, function (Faker $faker) {
    return [
        'file_path'   => $faker->url,
        'title'       => $faker->sentences(1, true),
        'description' => $faker->sentences(3, true),
        'active'      => $faker->randomElement([0, 1]),
        'school_id'   => $faker->randomElement(School::pluck('id')->toArray()),
        'user_id'     => function() use ($faker) {
            if (User::count())
                return $faker->randomElement(User::pluck('id')->toArray());
            else return factory(User::class)->create()->id;
        },
    ];
});
