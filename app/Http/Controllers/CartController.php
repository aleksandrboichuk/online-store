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
     * Cart page
     *
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public function index(Request $request): Application|Factory|View|string
    {
        $cart = $this->getCart();

        //  AJAX for refresh amount of product in the cart
        if ($request->get('updateId') && $request->get('updateSize') && $request->get('value')) {

            $cart->updateProductCount($request);

            if ($request->ajax()) {
                return view('pages.cart.ajax.index', [
                    'cart'     => $cart,
                    'products' => $cart->products
                ])->render();
            }
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('pages.cart.index', [
            'promocodes'    => $this->user()?->getPromocodes(),
            'products'      => $cart->products ?? null,
            'breadcrumbs'   => $this->breadcrumbs
        ]);
    }

    /**
     * Get the breadcrumbs array
     *
     * @return array[]
     */
    private function getBreadcrumbs(): array
    {
        return [
            ['Головна', route('index', 'women')],
            ["Кошик"],
        ];
    }

    /**
     * Deleting product from cart
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteFromCart(Request $request): RedirectResponse
    {
        $cart = $this->getCart();

        $cart->deleteProduct($request);

        return redirect()->back()->with([
            'success-message-delete' => 'Товар успішно видалено з кошику.'
        ]);
    }
}
