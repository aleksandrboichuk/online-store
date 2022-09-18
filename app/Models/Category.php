<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends BaseModel
{
    protected $fillable = [
        'title',
        'name',
        'seo_name',
        'active',
        'created_at',
        'updated_at',
        'category_group'
        ];

    /**
     * Связь категории - продукты
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }

    /**
     * Category - category group relation
     *
     * @return HasOne
     */
    public function categoryGroup(): HasOne
    {
        return $this->hasOne(CategoryGroup::class, 'id', 'category_group');
    }

    /**
     * Связь категории-подкатегории
     * @return HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany('App\Models\SubCategory','category_id','id');
    }
}
