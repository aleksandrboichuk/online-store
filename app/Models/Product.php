<?php

namespace App\Models;

use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
     * @return HasOne
     */
    public function categoryGroup(): HasOne
    {
        return $this->hasOne(CategoryGroup::class,'id', 'category_group_id');
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

    /**
     * Attaches sizes to product in database
     *
     * @param ProductRequest $request
     * @return void
     */
    public function updateSizes(ProductRequest $request): void
    {
        $sizes = $request->get('sizes');
        $sizes_count = $request->get('size-count');

        $this->sizes()->detach();

        if ($sizes && $sizes_count){

            $sizes_count = array_values(array_filter($sizes_count, fn($value) => !is_null($value)));

            foreach ($sizes as $key => $size) {
                $this->sizes()->attach($this->id,[
                    'product_size_id' => $size,
                    'count' =>  $sizes_count[$key] ?? 1
                ]);
            }
        }
    }

    /**
     * Updates product total count field
     *
     * @return void
     */
    public function updateProductCountField(): void
    {
        if(isset($this->sizes) && !empty($this->sizes)){
            $count = 0;
            foreach ($this->sizes as $s){
                $count += $s->pivot->count;
            }
            $this->update([
                'count' => $count
            ]);
        }
    }

    /**
     * Attaches materials to product in database
     *
     * @param ProductRequest $request
     * @return bool
     */
    public function updateMaterials(ProductRequest $request): bool
    {
        $materials = $request->get('materials');

        $this->materials()->detach();

        if($materials){

            foreach ($materials as $material){
                $this->materials()->attach($material);
            }

            return true;
        }

        return false;
    }

    /**
     * Returns array with ids of some relation
     *
     * @param string $relation
     * @return array
     */
    public function getRelationIds(string $relation): array
    {
        $arrIds = [];

        if($this->{$relation}){
            foreach ($this->{$relation} as $item) {
                $arrIds[] = $item->id;
            }
        }

        return $arrIds;
    }

    /**
     * Returns array with count of products in every size
     *
     * @return array
     */
    public function getSizesCount(): array
    {
        $sizes_count = [];

        foreach ($this->sizes()->get() as $size) {
            $sizes_count[$size->id] = $size->pivot->count;
        }

        return $sizes_count;
    }

    /**
     * Saving additional product images to the storage
     *
     * @param ProductRequest $request
     * @param int $from
     * @param int $to
     * @return void
     */
    public function saveAdditionalImages(ProductRequest $request, int $from = 0, int $to = 7): void
    {
        $additional_images = [];

        for($i = $from; $i <= $to; $i++){
            if($additional_image = $request->file('additional-image-' . $i)){

                $this->storeImage($additional_image, "details");

                $additional_images[$i]['url'] = $additional_image->getClientOriginalName();
                $additional_images[$i]['product_id'] = $this->id;
            }
        }

        if(!empty($additional_images)){
            $this->attachAdditionalImages($additional_images);
        }
    }


    /**
     * Attach in database images to product
     *
     * @param array $additional_images
     * @return void
     */
    public function attachAdditionalImages(array $additional_images): void
    {
        foreach($additional_images as $additional_image){
            ProductImage::query()->create($additional_image);
        }
    }

    /**
     * Stores a product image in storage
     *
     * @param UploadedFile $file
     * @param string $path
     * @return void
     */
    public function storeImage(UploadedFile $file, string $path): void
    {
        Storage::disk('products')->putFileAs("$this->id/$path/", $file, $file->getClientOriginalName());
    }

    /**
     * Deletes a product image in storage
     *
     * @param string $path
     * @param string $image_name
     * @return void
     */
    public function deleteImage(string $path, string $image_name): void
    {
        ProductImage::query()->where('url', $image_name)->delete();
        Storage::disk('products')->delete("$this->id/$path/$image_name");
    }


    /**
     * Replace product images from request if request has their new
     *
     * @param ProductRequest $request
     * @return void
     */
    public function updateAdditionalImages(ProductRequest $request): void
    {
        $product_images = $this->images;

        foreach ($product_images as $key => $image) {

            if ($request->hasFile('additional-image-' . $key)) {

                $this->deleteImage( 'details', $image->url);

                $image->delete();
            }
        }

        $this->saveAdditionalImages($request, 0, count($product_images));
    }

    /**
     * Replace product images from request if request has their new
     *
     * @param ProductRequest $request
     * @return void
     */
    public function updatePreviewImage(ProductRequest $request): void
    {
        if($preview_img = $request->file('preview_image')){

            $this->deleteImage('preview', $this->preview_img_url);

            $this->storeImage($preview_img, "preview");

        }
    }

    /**
     * Deleting old banner image in storage
     *
     * @return void
     */
    public function deleteFolder(): void
    {
        Storage::disk('products')->deleteDirectory($this->id);
    }
}
