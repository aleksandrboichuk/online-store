<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReview extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'grade',
        'review'
    ];

    /**
     * Связь отзывы-юзеры
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }

    /**
     * Получение отзывов о продукте
     * @param int $product_id
     * @return LengthAwarePaginator
     */
    public static function getPaginatedProductReviews(int $product_id): LengthAwarePaginator
    {
        return self::query()->where('product_id', $product_id)->paginate(2);
    }

    /**
     * Создание отзыва
     * @param Request $request
     * @param $product_id
     * @return bool
     */
    public static function createReview(Request $request, $product_id): bool
    {
        UserReview::create([
            'product_id' => $product_id,
            'user_id' =>  Auth::id(),
            'grade' => $request->get('grade'),
            'review' => $request->get('review')
        ]);

        return true;
    }

    /**
     * Returns reviews by product id
     *
     * @param $product_id
     * @return Collection|array
     */
    public static function getProductReviews($product_id): Collection|array
    {
        return self::query()->where('product_id',  $product_id)->get();
    }
}
