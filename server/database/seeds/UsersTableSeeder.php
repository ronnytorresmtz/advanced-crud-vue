<?php

use Illuminate\Database\Seeder;
use MyCode\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();

        User::create(array(
            'name'      => 'Rolando Torres Martinez',
            'email'     => 'rtorresmtz@hotmail.com',
            'password'  => Hash::make('rtorresmtz')
        ));

        User::create(array(
            'name'      => 'Ronny Torres Martinez',
            'email'     => 'ronnytorresmtz@gmail.com',
            'password'  => Hash::make('ronnytorresmtz')
        ));

        User::create(array(
            'name'      => 'Demo User',
            'email'     => 'demo123@gmail.com',
            'password'  => Hash::make('demo123')
        ));
    }
}
