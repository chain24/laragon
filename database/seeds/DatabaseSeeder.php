<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SchoolTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SectionTableSeeder::class);
        $this->call(ClassesTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(BookSeederTable::class);
        $this->call(ExamSeederTable::class);
        $this->call(EventSeederTable::class);
        $this->call(SyllabusSeederTable::class);
    }
}
