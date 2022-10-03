<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'active'
    ];

    protected $table = 'seasons';

    /**
     * Связь Сезон - продукты
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'product_season_id', 'id');
    }
}
