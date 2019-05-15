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
    }
}