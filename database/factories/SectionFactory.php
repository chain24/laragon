<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19.5.14
 * Time: 9:32
 */

use Faker\Generator as Faker;

$factory->define(\App\Models\Section::class,function (Faker $faker){
    return [
        'section_number' => $faker->randomElement(['A', 'B','C','D','E','F','G','H','I','J','K','L','M']),
        'room_number' => $faker->randomDigitNotNull,
        'class_id' => function() use ($faker) {
            if (\App\Models\Myclass::count()){
                return $faker->randomElement(\App\Models\Myclass::pluck('id')->toArray());
            }else{
                return factory(\App\Models\Myclass::class)->create()->id;
            }
        }
    ];
});
