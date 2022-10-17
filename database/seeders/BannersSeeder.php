<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannersSeeder extends Seeder
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

        if($women && Storage::disk('banners')->exists('temp_images_sales_10_percent')){
            $women_banner = Banner::query()->create([
                'title' => 'ЗНИЖКИ -10%',
                'seo_name' => 'sales-10-percent',
                'description' => 'Цієї п\'ятниці діють знижки на товари усіх категорій для жінок! Знижки діятимуть усі вихідні. Встигніть придбати бажаний товар по низькій ціні!',
                'image_url' => 'sales-10-percent.jpg',
                'active' => 1,
                'category_group_id' => $women->id,
            ]);

            Storage::disk('banners')->makeDirectory($women_banner->id);
            Storage::disk('banners')->put($women_banner->id, Storage::disk('banners')->get('temp_images_sales_10_percent'));

        }

        if($men && Storage::disk('banners')->exists('temp_images_new_men_collection')){
            $men_banner = Banner::query()->create([
                'title' => 'НОВА КОЛЕКЦІЯ ДЛЯ ЧОЛОВІКІВ',
                'seo_name' => 'new-men-collection',
                'description' => 'Вже у наявності нова колекція для чоловіків! У перші 4 дні, а саме з 10.10 до 14.10 буде діяти знижка на цю колекцію у розмірі -15% від вартості товару колекції.',
                'image_url' => 'new-men-collection.jpg',
                'active' => 1,
                'category_group_id' => $men->id,
            ]);

            Storage::disk('banners')->makeDirectory($men_banner->id);
            Storage::disk('banners')->put($men_banner->id, Storage::disk('banners')->get('temp_images_new_men_collection'));
        }
    }
}
