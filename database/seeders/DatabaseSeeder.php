<?php

namespace Database\Seeders;

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
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            CategoryGroupsSeeder::class,
            CategoriesSeeder::class,
            SubCategoriesSeeder::class,
            StatusesSeeder::class,
            BannersSeeder::class,
            ProductsPropertiesSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}
