<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'seo_name',
        'preview_img_url',
        'description',
        'price',
        'discount',
        'banner_id',
        'count',
        'in_stock',
        'active',
        'rating',
        'popularity',
        'created_at',
        'updated_at',
        'category_group_id',
        'category_id',
        'category_sub_id',
        'product_color_id',
        'product_season_id',
        'product_brand_id',
    ];

    /**
     * Связь продукт - категории
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id', 'id');
    }

    /**
     * Связь продукт - группы категорий
     * @return BelongsTo
     */
    public function categoryGroups(): BelongsTo
    {
        return $this->belongsTo(CategoryGroup::class,'category_group_id', 'id');
    }

    /**
     * Связь продукт - подкатегории
     * @return BelongsTo
     */
    public function subCategories(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class,'category_sub_id', 'id');
    }

    /**
     * Связь продукт - отзывы
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(UserReview::class,'product_id', 'id');
    }

    /**
     * Связь продукт - бренды
     * @return BelongsTo
     */
    public function brands(): BelongsTo
    {
        return $this->belongsTo(ProductBrand::class,'product_brand_id', 'id');
    }

    /**
     * Связь продукт - цвета
     * @return BelongsTo
     */
    public function colors(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class,'product_color_id', 'id');
    }

    /**
     * Связь продукт - сезоны
     * @return BelongsTo
     */
    public function seasons(): BelongsTo
    {
        return $this->belongsTo(ProductSeason::class,'product_season_id', 'id');
    }

    /**
     * Связь продукт - материалы
     * @return BelongsToMany
     */
    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(ProductMaterial::class, 'product_product_material');
    }

    /**
     * Связь продукт - размеры
     * @return BelongsToMany
     */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class, 'product_product_size')->withPivot('count');
    }

    /**
     * Связь продукт - картинки
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    /**
     * Связь продукт - корзины
     * @return BelongsToMany
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'product_carts');
    }


    /**
     * Получение статуса остатка товара на складе
     * @return string[]
     */
    public function getProductAmountStatus(): array
    {
        $stockStatus = [];
        $amount = $this->count;

        if($amount > 50){
            $stockStatus = ['in-stock', 'У наявності'];
        }elseif($amount <= 50){
            $stockStatus = ['ends-in-stock', 'Закінчується'];
        }elseif($amount == 0){
            $stockStatus = ['not-in-stock', 'Закінчився'];
        }elseif(!$this->in_stock){
            $stockStatus = ['not-in-stock', 'Немає у наявності'];
        }

        return $stockStatus;
    }

    /**
     * Получение рекомендованых продуктов
     * @param int $group_id
     * @return Builder[]|Collection
     */
    public static function getRecommendedProducts(int $group_id): Collection|array
    {
        return self::query()->where('category_group_id', $group_id)
            ->where('active', 1)
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    /**
     * @param float $grade
     * @return bool
     */
    public function updateRating(float $grade): bool
    {
       return $this->update([
            'rating' => $grade
        ]);
    }

    /**
     * Получение цены продукта
     * @return float|mixed
     */
    public function getProductPriceWithDiscount(): mixed
    {
        if($this->discount != 0){
            $price = $this->price - (round($this->price * ($this->discount * 0.01)));
        }else{
            $price = $this->price;
        }

        return $price;
    }

    /**
     * Получение продуктов для вывода на странице акции (баннера)
     * @param int $banner_id
     * @param int $group_id
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public static function getProductsForPromotion(int $banner_id, int $group_id, int $perPage = 6): LengthAwarePaginator
    {
        return self::query()
            ->where('banner_id', $banner_id)
            ->where('category_group_id', $group_id)
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Update product every size count
     *
     * @param int $size_name
     * @param int $count
     * @return void
     */
    public function updateSizesCount(int $size_name, int $count): void
    {
        $size = $this->sizes()->where('product_sizes.name', $size_name)->first();

        $this->sizes()
            ->where('product_size_id', $size->id)
            ->update([
            'count' =>  $size->pivot->count - $count
        ]);
    }

    /**
     * Update product total count field and popularity field
     *
     * @param int $count
     * @return void
     */
    public function updateTotalCountAndPopularity(int $count): void
    {
        $this->update([
            'count'      => $this->count - $count,
            'popularity' => $this->popularity + 1
        ]);
    }
}
