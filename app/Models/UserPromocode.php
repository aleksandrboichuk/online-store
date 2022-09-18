<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserPromocode extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount',
        'min_cart_total',
        'min_cart_products',
        'promocode',
        'active',
    ];

    /**
     * Связь промокод - юзеры
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * Получение промокода по коду
     * @param $promocode
     * @return Builder|Model|null
     */
    public static function getPromocode($promocode): Model|Builder|null
    {
        return self::query()->where('promocode', $promocode)->first();
    }
}
