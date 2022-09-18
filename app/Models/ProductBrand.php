<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductBrand extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'active'
    ];

    /**
     * Связь бернд - продукты
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\Models\Product','product_brand_id', 'id');
    }
}
