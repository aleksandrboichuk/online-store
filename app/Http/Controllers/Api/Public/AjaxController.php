<?php

namespace App\Http\Controllers\Api\Public;


use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AjaxController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns categories of category group or subcategories of category by their ids
     *
     * @param Request $request
     * @return string
     */
    public function updateCart(Request $request): string
    {
        $cart = $this->getCart();

        $cart->updateProductCount($request);

        return view('pages.cart.ajax.index', [
            'cart'     => $cart,
            'products' => $cart->products
        ])->render();
    }

    /**
     * Adding or updating product in the cart
     *
     * @param Request $request
     * @return int
     */
    public function addToCart(Request $request): int
    {
        $cart = $this->getCart();

        $product_id = $request->get('productId');
        $product_size = $request->get('productSize');
        $product_count = $request->get('productCount');

        $was_product_updated = $cart->updateCartProductCount($product_id, $product_size, $product_count);

        if (!$was_product_updated) {
            $cart->addProductToTheCart($product_id, $product_size, $product_count);
        }

        return $cart->products()->count();
    }
}
