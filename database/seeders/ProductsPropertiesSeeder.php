<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Material;
use App\Models\Season;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ProductsPropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::query()->create([
            'name' => 'Блакитний',
            'seo_name' => 'blue',
        ]);

        Color::query()->create([
            'name' => 'Чорний',
            'seo_name' => 'black',
        ]);

        Brand::query()->create([
            'name' => 'House Brand',
            'seo_name' => 'housebrand',
        ]);

        Brand::query()->create([
            'name' => 'Bershka',
            'seo_name' => 'bershka',
        ]);

        Season::query()->create([
            'name' => 'Весна',
            'seo_name' => 'spring',
        ]);

        Season::query()->create([
            'name' => 'Літо',
            'seo_name' => 'summer',
        ]);

        Size::query()->create([
            'name' => '44',
            'seo_name' => 'size-44',
        ]);

        Size::query()->create([
            'name' => '26',
            'seo_name' => 'size-26',
        ]);

        Material::query()->create([
            'name' => 'Поліестер',
            'seo_name' => 'polyester',
        ]);

        Material::query()->create([
            'name' => 'Бавовна',
            'seo_name' => 'cotton',
        ]);
    }
}
