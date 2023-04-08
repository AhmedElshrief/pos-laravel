<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\User::class, 1)->create();
        $user = \App\User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'super@admin.com',
            'password' => bcrypt('admin'),
        ]);

        $user->attachRole('super_admin');

    }
}
