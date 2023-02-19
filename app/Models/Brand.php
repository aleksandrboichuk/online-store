<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'active'
    ];

    protected $table = 'brands';

    /**
     * Связь бернд - продукты
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'brand_id', 'id');
    }
}
