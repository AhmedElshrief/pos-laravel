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
        $this->call(LaratrustSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);

        for ($i = 1; $i <= 4
        ; $i++)
        {
            $user = \App\User::create([
                'first_name' => 'test ' . $i,
                'last_name' => 'test' . $i,
                'email' => 'test@test'. $i . '.com',
                'password' => bcrypt('admin'),
            ]);

            $user->attachRole('admin');

        }


    }
}
