<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class D_SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clothes_women = Category::getOneBySeoName('women-clothes');
        $clothes_men = Category::getOneBySeoName('men-clothes');

        if($clothes_women){
            SubCategory::query()->create([
                'title' => 'Джинси жіночі',
                'name' => 'Джинси',
                'seo_name' => 'jeans-women',
                'category_id' => $clothes_women->id,
                'active' => 1,
            ]);
        }

        if($clothes_men){
            SubCategory::query()->create([
                'title' => 'Сорочки чоловічі',
                'name' => 'Сорочки',
                'seo_name' => 'shirt-men',
                'category_id' => $clothes_men->id,
                'active' => 1,
            ]);
        }
    }
}
