<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends BaseModel
{
    protected $fillable = [
        'title',
        'name',
        'seo_name',
        'parent_id',
        'level',
        'url',
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
        return $this->hasMany(Product::class, 'category_id', 'id');
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
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    /**
     * Связь категории-подкатегории
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class,'parent_id','id')->with('categories');
    }

    /**
     * Recursively count category level
     *
     * @param int $level
     * @return int
     */
    private function getLevel(int $level = 1): int
    {
        if($parent = $this->parent){

            $level++;

            return $this->getCategoryLevel($parent, $level);
        }

        return $level;
    }

    /**
     * Returns product of category by seo name
     *
     * @param string $seo_name
     * @return Model|HasMany|null
     */
    public function getProductBySeoName(string $seo_name): Model|HasMany|null
    {
        return $this->products()
            ->where('active', 1)
            ->where('seo_name', $seo_name)
            ->first();
    }

    /**
     * Returns url to category page
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->parent
            ? route('category', [$this->categoryGroup->seo_name, $this->parent->seo_name, $this->seo_name], false)
            : route('category', [$this->categoryGroup->seo_name, $this->seo_name], false);
    }

    /**
     * Get all active categories of category
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories()->where('active', 1)->get();
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

    /**
     * Recursively get child category IDs
     *
     * @param $category
     * @param array $categories = []
     * @return array
     */
    private static function getChildCategoryIds($category, array $categories = []): array
    {
        $items = self::query()
            ->where('parent_id', $category->id)
            ->where('active', 1)
            ->select('id')
            ->get();

        if (!$items) {
            return $categories;
        }

        foreach ($items as $item) {
            $categories[] = $item->id;
            $categories = self::getChildCategoryIds($item, $categories);
        }

        return $categories;
    }

    /**
     * Returns paginated products collection of category
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginateProducts(int $perPage = 8): LengthAwarePaginator
    {
        $childCategoryIds = $this->getChildCategoryIds($this);

        $childCategoryIds[] = $this->id;

        return Product::retrieveByCategories($childCategoryIds, $perPage);
    }

    /**
     * Getting all active nested categories
     *
     * @return Builder[]|Collection
     */
    public function getNestedCategories(array $selectedFields = ['*']): Collection|array
    {
        $childCategoryIds = $this->getChildCategoryIds($this);

        return $this
            ->query()
            ->whereIn('id', $childCategoryIds)
            ->select($selectedFields)
            ->get();
    }

}
