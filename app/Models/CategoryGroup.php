<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryGroup extends BaseModel
{

    protected $fillable = [
        'category_group_id',
        'category_id',
        'created_at',
        'updated_at',
    ];

    use HasFactory;


    /**
     * Returns array with matched seo_names and ids of active category groups
     *
     * @return array
     */
    public static function getCategoryGroupsArray(): array
    {
        $matched_array = [];

        foreach (self::getActiveEntries() as $item) {
            $matched_array[$item->seo_name] = $item->id;
        }

        return $matched_array;
    }
    /**
     * Связь группа - продукты
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\Models\Product', 'category_group_id', 'id');
    }

    /**
     * Связь группа - категории
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'category_group', 'id');
    }

    /**
     * Получение всех активных категорий группы
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories()->where('active', 1)->get();
    }

}
