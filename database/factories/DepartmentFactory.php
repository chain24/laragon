<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Department::class, function (Faker $faker) {
    return [
        'school_id' => function() use ($faker){
            if (\App\Models\School::count()){
                return $faker->randomElement(\App\Models\School::pluck('id')->toArray());
            }else{
                return factory(\App\Models\School::class)->create();
            }
        },
        'department_name' => $faker->randomElement(['Bangla','English','Math']),
    ];
});
