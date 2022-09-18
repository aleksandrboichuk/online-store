<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'name',
        'seo_name',
        'active',
        'category_id'
    ];

    /**
     * Связь под-категория - продукты
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\Models\Product', 'category_sub_id', 'id');
    }

    /**
     * Связь под-категория - категория
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
}
