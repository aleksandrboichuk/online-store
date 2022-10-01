<?php

namespace App\Http\Controllers\Profile;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserSettingsRequest;
use App\Models\OrdersList;
use App\Models\StatusList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class PromocodeController extends Controller
{
    /**
     * Promocodes page
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $user =  $this->user();

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('pages.profile.promocodes', [
            'promocodes' => $user->promocodes ?? null,
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
            ['Особистий кабінет'],
            ['Промокоди'],
        ];
    }
}
