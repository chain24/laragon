<?php

use Illuminate\Database\Seeder;
use App\Models\StudentInfo;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(StudentInfo::class, 50)->states('without_group')->create();
        factory(StudentInfo::class, 25)->states('science')->create();
        factory(StudentInfo::class, 15)->states('commerce')->create();
        factory(StudentInfo::class, 10)->states('arts')->create();
    }
}
