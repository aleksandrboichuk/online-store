<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
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
            $clothes_women = Category::query()->create([
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
            $clothes_men = Category::query()->create([
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

        if(isset($clothes_women)){
            Category::query()->create([
                'title' => 'Джинси жіночі',
                'name' => 'Джинси',
                'seo_name' => 'jeans-women',
                'parent_id' => $clothes_women->id,
                'category_group' => $clothes_men->category_group,
                'active' => 1,
            ]);
        }

        if(isset($clothes_men)){
            Category::query()->create([
                'title' => 'Сорочки чоловічі',
                'name' => 'Сорочки',
                'seo_name' => 'shirt-men',
                'parent_id' => $clothes_men->id,
                'category_group' => $clothes_men->category_group,
                'active' => 1,
            ]);
        }

    }
}
