<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Banner extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_group_id',
        'seo_name',
        'description',
        'image_url',
        'mini_img_url',
        'active',
    ];

    /**
     * Relation banners - category groups
     *
     * @return HasOne
     */
    public function categoryGroup(): HasOne
    {
        return $this->hasOne('App\Models\CategoryGroup','id', 'category_group_id');
    }

    /**
     * Получение всех баннеров группы категорий
     * @param $group_id
     * @return Builder[]|Collection
     */
    public static function getBanners($group_id): Collection|array
    {
        return self::query()->where('active', 1)->where('category_group_id', $group_id)->get();
    }

    /**
     * Получение баннера по сео имени
     * @param string $seo_name
     * @return Builder|Model|null
     */
    public static function getBannerBySeoName(string  $seo_name): Model|Builder|null
    {
        return self::query()->where('seo_name', $seo_name)->where('active', 1)->first();
    }

    /**
     * Получаем все баннеры конкретной группы категории по ее айди
     *
     * @param int $group_id
     * @return Builder[]|Collection
     */
    public static function getBannersByGroupId(int $group_id): Collection|array
    {
       return self::query()->where('active', 1)->where('category_group_id', $group_id)->get();
    }

    /**
     * Saving banner image to storage
     *
     * @param UploadedFile $image
     * @return void
     */
    public function saveImage(UploadedFile $image): void
    {
        (bool)Storage::disk('banners')->putFileAs($this->id, $image, $image->getClientOriginalName());
    }


    /**
     * Deleting old and saving new file image of banner in storage
     *
     * @param UploadedFile $image
     * @return void
     */
    public function updateImageInStorage(UploadedFile $image): void
    {
        $this->deleteOldImage();
        Storage::disk('banners')->putFileAs($this->id, $image, $image->getClientOriginalName());
    }

    /**
     * Deleting old banner image in storage
     *
     * @return void
     */
    public function deleteOldImage(): void
    {
        Storage::disk('banners')->delete($this->id . '/' . $this->image_url);
    }

    /**
     * Deleting old banner image in storage
     *
     * @return void
     */
    public function deleteFolder(): void
    {
        Storage::disk('banners')->deleteDirectory($this->id);
    }
}
