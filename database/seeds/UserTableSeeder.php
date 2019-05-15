<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name'     => "chainsy",
            'email'    => 'chainsy97@gmail.com',
            'password' => bcrypt('secret'),
            'role'     => 'master',
            'active'   => 1,
            'verified' => 1,
            'phone_code'=> '12345678909',
            'student_code'=>'123456',
        ]);
        factory(\App\User::class, 10)->states('admin')->create();
        factory(\App\User::class, 10)->states('accountant')->create();
        factory(\App\User::class, 10)->states('librarian')->create();
        factory(\App\User::class, 30)->states('teacher')->create();
        factory(\App\User::class, 200)->states('student')->create();
    }
}
