<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    /**
     * Returns active products by relation with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginateProducts(int $perPage = 8): LengthAwarePaginator
    {
        return $this->products()->where('active', 1)->paginate($perPage);
    }

    /**
     * Returns active found entry by seo_name
     *
     * @param string $seo_name
     * @return Builder|object|null
     */
    public static function getOneBySeoName(string $seo_name): Model|Builder|null
    {
        return self::query()->where('seo_name', $seo_name)->where('active', 1)->first();
    }

    /**
     * Getting all active entries
     *
     * @return Builder[]|Collection
     */
    public static function getActiveEntries(): Collection|array
    {
        return self::query()->where('active', 1)->get();
    }
}
