<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Myclass::class, function (Faker $faker) {
    static $class_number = 0;
    return [
        'class_number' => $class_number++,
        'school_id'    => function() use ($faker){
            if (\App\Models\School::count()){
                return $faker->randomElement(\App\Models\School::pluck('id')->toArray());
            }else{
                return factory(\App\Models\School::class)->create();
            }

        },
         'group' => function() use ($class_number,$faker){
             $element = $faker->randomElement(['science', 'commerce', 'arts']);
             return ($class_number > 8) ? $element : "";
         }
    ];
});
