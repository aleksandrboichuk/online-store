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
     * @return Application|Factory|View|string
     */
    public function index(): Application|Factory|View|string
    {
        $cart = $this->getCart();

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
