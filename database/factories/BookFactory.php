<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Book::class, function (Faker $faker) {
    return [
        'book_code' => 'bk'.$faker->unique()->randomNumber(7, false),
        'title'     => $faker->sentences(1, true),
        'author'    => $faker->name,
        'quantity'  => $faker->randomElement([5,8,19,13,34]),
        'rackNo'    => $faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12]),
        'rowNo'     => $faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12]),
        'type'      => $faker->randomElement(['Academic','Magazine','Story','Other']),
        'img_path'  => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'about'     => $faker->sentences(3, true),
        'price'     => $faker->randomFloat('2',1,199),
        'class_id'  => function() use ($faker) {
            if (\App\Models\Myclass::count() > 0) {
                return $faker->randomElement(\App\Models\Myclass::pluck('id')->toArray());
            } else return factory(\App\Models\Myclass::class)->create()->id;
        },
        'school_id'  => function() use ($faker) {
            if (\App\Models\School::count() > 0) {
                return $faker->randomElement(\App\Models\School::pluck('id')->toArray());
            } else return factory(\App\Models\School::class)->create()->id;
        },
        'user_id'   => function() use ($faker) {
            if (\App\User::where('role','librarian')->count() > 0) {
                return $faker->randomElement(\App\User::where('role','librarian')->pluck('id')->toArray());
            } else
                return factory(\App\User::class)->states('librarian')->create()->id;
        }
    ];
});
