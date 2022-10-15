<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusList extends BaseModel
{
    use HasFactory;

    /**
     * Getting entry by seo name
     *
     * @param string $seo_name
     * @return Model|Builder|null
     */
    public static function getOneBySeoName(string $seo_name): Model|Builder|null
    {
        return self::query()->where('seo_name', $seo_name)->first();
    }
}
