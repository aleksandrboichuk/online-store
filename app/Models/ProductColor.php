<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductColor extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'active'
    ];


    use HasFactory;

    /**
     * Связь цвет - продукты
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\Models\Product','product_color_id', 'id');
    }
}
