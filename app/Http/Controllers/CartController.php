<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * Страница корзины
     *
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public function index(Request $request): Application|Factory|View|string
    {
        $user = $this->user();
        $cart = $this->getCart();

        //   AJAX обновления количества продукта в корзине
        if ($request->get('updateId') && $request->get('updateSize') && $request->get('value')) {

            $product_id = $request->get('updateId');
            $size = $request->get('updateSize');
            $value = $request->get('value');

            $cart->updateProductCount($product_id, $size, $value);

            if ($request->ajax()) {
                return view('ajax.ajax-cart', [
                    'user' => $this->user(),
                    'cart' => $cart,
                    'products' => $cart->products
                ])->render();
            }
        }

        return view('cart.cart', [
            'promocodes' => $user->promocodes ?? null,
            'products' => $cart->products ?? null
        ]);
    }

    /**
     * Удаление товара из корзины
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteFromCart(Request $request){

        $cart = $this->getCart();

        $product_id = $request->get('delete-id');
        $size = $request->get('size');

        if($product_id && $size) {
            $cart->deleteProduct($product_id, $size);
        }

         return redirect()->back()->with([
             'success-message-delete' => 'Товар успішно видалено з кошику.'
         ]);
    }

}
