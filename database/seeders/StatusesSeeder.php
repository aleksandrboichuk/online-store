<?php

namespace Database\Seeders;

use App\Models\StatusList;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusList::query()->create([
            'name' => 'Новий',
            'seo_name' => 'new',
        ]);

        StatusList::query()->create([
            'name' => 'Оброблений',
            'seo_name' => 'processed',
        ]);

        StatusList::query()->create([
            'name' => 'Оплачений',
            'seo_name' => 'paid',
        ]);

        StatusList::query()->create([
            'name' => 'Доставляється',
            'seo_name' => 'delivering',
        ]);

        StatusList::query()->create([
            'name' => 'Доставлений',
            'seo_name' => 'delivered',
        ]);

        StatusList::query()->create([
            'name' => 'Завершений',
            'seo_name' => 'completed',
        ]);
    }
}
