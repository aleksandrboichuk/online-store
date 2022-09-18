<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class AdminController extends Controller
{

    /**
     * Страница админки
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index():Application|Factory|\Illuminate\Contracts\View\View
    {
        return view('admin.index');
    }

    /**
     * Set active field to related entries for selected model
     *
     * @param Model $model
     * @param bool $active
     * @param string|array $relations
     * @return bool
     */
    public function setActiveFieldToCategoryRelations(Model $model, bool $active, string|array $relations): bool
    {
        if(is_array($relations)) {
            foreach ($relations as $relation) {

                if(!isset($model->{$relation})) {
                    return false;
                }

                foreach ($model->{$relation} as $item) {
                    $item->update(['active' => $active]);
                }
            }
        }else{
            if(!isset($model->{$relations})) {
                return false;
            }

            foreach ($model->{$relations} as $item) {
                $item->update(['active' => $active]);
            }
        }

        return true;
    }
}
