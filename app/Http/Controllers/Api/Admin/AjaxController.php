<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;

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
    public function getCategoriesOrSubcategoriesData(Request $request): string
    {
        $group = $request->get('categoryGroup');
        $category = $request->get('category');

        $model = $group ? new CategoryGroup() : ($category ? new Category() : null);

        $id = $group ?? ($category ?? null);

        $result = $model?->query()->find($id);

        return view('admin.product.ajax.select-categories', [
            'items' => $result ? $result->categories()->get() : []
        ])->render();
    }
}
