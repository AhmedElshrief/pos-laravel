<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\Category::class, 5)->create();

        $categories = ['cat one', 'cat two'];

        foreach ($categories as $category) {
            \App\Category::create([
                'ar' => ['name' => $category],
                'en' => ['name' => $category]
            ]);
        }
    }
}
