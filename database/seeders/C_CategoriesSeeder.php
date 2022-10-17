<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;

class C_CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $women = CategoryGroup::getOneBySeoName('women');
        $men = CategoryGroup::getOneBySeoName('men');

        if($women){
            Category::query()->create([
                'title' => 'Одяг жіночий',
                'name' => 'Одяг',
                'seo_name' => 'women-clothes',
                'category_group' => $women->id,
                'active' => 1,
            ]);

            Category::query()->create([
                'title' => 'Взуття жіноче',
                'name' => 'Взуття',
                'seo_name' => 'women-shoes',
                'category_group' => $women->id,
                'active' => 1,
            ]);
        }

        if($men){
            Category::query()->create([
                'title' => 'Одяг чоловічий',
                'name' => 'Одяг',
                'seo_name' => 'men-clothes',
                'category_group' => $men->id,
                'active' => 1,
            ]);

            Category::query()->create([
                'title' => 'Взуття чоловіче',
                'name' => 'Взуття',
                'seo_name' => 'men-shoes',
                'category_group' => $men->id,
                'active' => 1,
            ]);
        }
    }
}
