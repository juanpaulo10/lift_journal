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
        //make a single user.
        factory( App\User::class )->create([
            'name' => 'Bob Doe',
            'email' => 'bob_d@example.com',
            'password' => bcrypt('123456')
        ]);
    }
}
