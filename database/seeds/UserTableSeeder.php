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
        \App\User::insert([
            'name' => 'Mher',
            'email' => 'mher@gmail.com',
            'password'=>bcrypt('secret')
        ]);
    }
}
