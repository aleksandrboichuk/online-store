<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        ];

    /**
     * связь корзина - продукты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(){
        return $this->belongsToMany('App\Models\Product')->withPivot('product_count', 'size');
    }

    /**
     * Связь корзина - юзер
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(){
        return $this->hasOne('App\Models\User');
    }

    /**
     * обновление количества продукта в корзине
     * @param int $product_id
     * @param int $size
     * @param int $value
     * @return int
     */
    public function updateProductCount(int $product_id, int $size, int $value){
        return $this->products()
            ->where("product_id", $product_id)
            ->where('size', $size)
            ->update(["product_count" => $value]);

    }

    /**
     * удаление продукта из корзины
     * @param int $product_id
     * @param int $size
     * @return int
     */
    public function deleteProduct(int $product_id, int $size)
    {
        return $this->products()
            ->where('product_id', $product_id)
            ->where('size', $size)
            ->detach();
    }

    /**
     * Считает сумму товаров в корзине
     * @return float|int
     */
    public function calculateTotal()
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
}
