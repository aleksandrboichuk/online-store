<?php

namespace Database\Seeders;

use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;

class CategoryGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryGroup::query()->create([
            'name' => 'Жінкам',
            'seo_name' => 'women',
        ]);

        CategoryGroup::query()->create([
            'name' => 'Чоловікам',
            'seo_name' => 'men',
        ]);
    }
}
