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

class SettingsController extends Controller
{

    /**
     * Settings page
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('pages.profile.settings', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Сохранение настроек
     * @param UserSettingsRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function saveUserSettings(UserSettingsRequest $request): Redirector|RedirectResponse|Application
    {
        $user = $this->user();

        if(!Hash::check($request->get('old-pass'), $user->password)) {
            return redirect()->back()->withInput($request->all())->with(['old-pass-error' => 'Пароль невірний.']);
        }

        $requestData = $request->except(['password']);

        //  if filled in a new password
        if($request->get('password')){
            $requestData['password'] = Hash::make($request->get('password'));
        }

        $this->updateUserData($requestData);

        return redirect('/personal/orders')->with(['settings-save-success' => 'Налаштування профілю успішно змінено.']);
    }

    /**
     * Updating data of user in database
     *
     * @param array $data
     * @return mixed
     */
    protected function updateUserData(array $data): mixed
    {
       return $this->user()->update($data);
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
            ['Налаштування'],
        ];
    }

}
