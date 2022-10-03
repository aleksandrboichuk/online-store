<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class BrandController extends AdminController
{

    /**
     * Index page
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $brands =  Brand::query()->orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.additional-to-products.brand.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BrandRequest $request): Redirector|RedirectResponse|Application
    {
        $request->setActiveField();

        Brand::query()->create($request->all());

        return redirect('/admin/brands')->with(['success-message' => 'Бренд успішно додано.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $brand = Brand::query()->find($id);

        if(!$brand){
           abort(404);
        }

        return view('admin.additional-to-products.brand.edit',compact('brand'));
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param BrandRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(BrandRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $brand = Brand::query()->find($id);

        if(!$brand) {
            abort(404);
        }

        $request->setActiveField();

        $brand->update($request->all());

        return redirect('admin/brands')->with(['success-message' => 'Бренд успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($id): Redirector|RedirectResponse|Application
    {
        $brand = Brand::query()->find($id);

        if(!$brand){
            abort(404);
        }

        $brand->delete();

        return redirect('admin/brands')->with(['success-message' => 'Бренд успішно видалено.']);
    }
}
