<?php

use Faker\Generator as Faker;
use App\User;
$factory->define(\App\Models\Notification::class, function (Faker $faker) {
    return [
        'sent_status' => $faker->randomElement([0, 1]),
        'active'      => $faker->randomElement([0, 1]),
        'message'     => $faker->sentences(3, true),
        'student_id'  => $faker->randomElement(User::student()->pluck('id')->toArray()),
        'user_id'     => function() use ($faker) {
            if (User::count())
                return $faker->randomElement(User::pluck('id')->toArray());
            else return factory(User::class)->create()->id;
        },
    ];
});
