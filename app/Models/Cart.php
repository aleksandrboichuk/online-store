<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

class Cart extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        ];

    /**
     * связь корзина - продукты
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_product', 'cart_id', 'product_id')
            ->withPivot('product_count', 'size');
    }

    /**
     * Связь корзина - юзер
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne('App\Models\User');
    }

    /**
     * @return Model|Builder|null
     */
    public static function getByToken(): Model|Builder|null
    {
        return self::query()->where('token', session()->getId())->first();
    }

    /**
     * Create cart by session token
     *
     * @return void
     */
    public static function createByToken(): void
    {
        self::query()->create([
            'token' => session()->getId()
        ]);
    }

    /**
     * обновление количества продукта в корзине
     *
     * @param Request $request
     * @return int
     */
    public function updateProductCount(Request $request): int
    {
        $product_id = $request->get('updateId');
        $size = $request->get('updateSize');
        $value = $request->get('value');

        return $this->products()
            ->where("product_id", $product_id)
            ->where('size', $size)
            ->update(["product_count" => $value]);
    }

    /**
     * Deleting product from cart by id
     *
     * @param Request $request
     * @return int
     */
    public function deleteProduct(Request $request): int
    {
        $product_id = $request->get('delete-id');
        $size = $request->get('size');

        return $this
            ->products()
            ->where('product_id', $product_id)
            ->wherePivot('size', $size)
            ->detach();
    }

    /**
     * Считает сумму товаров в корзине
     * @return float|int
     */
    public function getTotal(): float|int
    {
        $products = $this->products()->get();

        $total = 0;

        foreach ($products as $product) {
            $total += $product->pivot->product_count * $product->getProductPriceWithDiscount();
        }

       return $total;
    }


    /**
     * Update product count if it already exists in the user cart
     *
     * @param int $product_id
     * @param int $product_size
     * @param int $product_count
     * @return bool
     */
    public function updateCartProductCount(int $product_id, int $product_size, int $product_count): bool
    {
        $was_product_updated = false;

        $products  = $this->products()->get();

        if($products && count($products) > 0){

            $product = $this->products()
                ->where('product_id', $product_id)
                ->where('size', $product_size)
                ->first();

            if($product) {

                $this->products()
                    ->where('product_id', $product_id)
                    ->where('size', $product_size)
                    ->update([
                        'product_count'=> $product_count
                    ]);

                $was_product_updated = true;
            }
        }

        return $was_product_updated;
    }

    /**
     * Adding new product to the user cart
     *
     * @param int $product_id
     * @param int $product_count
     * @param int $product_size
     * @return void
     */
    public function addProductToTheCart(int $product_id, int $product_size, int $product_count): void
    {
        $this->products()->attach($product_id, [
            'cart_id' => $this->id,
            'product_id' => $product_id,
            'product_count' => $product_count,
            'size' => $product_size,
        ]);
    }

    /**
     * Delete products from cart
     *
     * @return void
     */
    private function clear(): void
    {
        foreach ($this->products as $product) {
            $product->pivot->delete();
        }
    }
}
