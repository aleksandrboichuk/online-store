<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * Returns list of banners by category group id
     *
     * @param int $category_group_id
     * @param string $order_by
     * @return Builder[]|Collection
     */
    public static function getListOfBanners(int $category_group_id, string $order_by = 'asc'): Collection|array
    {
        return self::query()
            ->where('category_group_id', $category_group_id)
            ->orderBy('id', $order_by)
            ->get();
    }
}
