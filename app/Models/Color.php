<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'active'
    ];

    protected $table = 'colors';

    use HasFactory;

    /**
     * Связь цвет - продукты
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'color_id', 'id');
    }
}
