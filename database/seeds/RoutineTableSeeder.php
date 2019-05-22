<?php

use Illuminate\Database\Seeder;

class RoutineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Routine::class,20)->create();
    }
}
