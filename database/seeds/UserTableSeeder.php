<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@m.io',
            'password' => Hash::make('password'),
        ]);
    }
}
