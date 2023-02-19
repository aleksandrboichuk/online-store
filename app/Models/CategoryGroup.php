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
        'name',
        'seo_name',
        'active',
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
     * Returns all brands of category group which has a products
     *
     * @return Builder[]|Collection
     */
    public function getBrands(): Collection|array
    {
        return Brand::query()
            ->where('active', 1)
            ->whereHas('products', function (Builder $query){
                return $query->where('category_group_id', $this->id);
            })
            ->get();
    }

    /**
     * Get all active categories of category group fro sidebar
     * @return Collection
     */
    public function getCategoriesForSidebar(): Collection
    {
        return $this->categories()
            ->where('active', 1)
            ->where('level', 1)
            ->get();
    }

    /**
     * Returns one child category by it seo name
     *
     * @param string|null $seo_name
     * @return mixed
     */
    public function getChildCategoryBySeoName(string|null $seo_name): mixed
    {
        return $this->categories()->where('seo_name', $seo_name)->where('active', 1)->first();
    }

}
