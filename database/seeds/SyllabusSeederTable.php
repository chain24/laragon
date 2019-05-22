<?php

use Illuminate\Database\Seeder;

class SyllabusSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Syllabus::class,50)->create();
    }
}
