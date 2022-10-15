<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BrandController extends AdminController
{
    /**
     * Index page
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $this->canSee('content');

        $brands =  Brand::query()->orderBy('id', 'desc')->get();

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.additional-to-products.brand.index',  [
            'brands' => $brands,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Get the breadcrumbs array
     *
     * @return array[]
     */
    protected function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        $breadcrumbs[] = ["Бренди"];

        return $breadcrumbs;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $this->canCreate('content');

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('brands',true));

        return view('admin.additional-to-products.brand.add', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BrandRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

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
        $this->canEdit('content');

        $brand = Brand::query()->find($id);

        if(!$brand){
           abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('brands',false));

        return view('admin.additional-to-products.brand.edit', [
            'brand' => $brand,
            'breadcrumbs' => $this->breadcrumbs
        ]);
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
        $this->canEdit('content');

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
        $this->canDelete('content');

        $brand = Brand::query()->find($id);

        if(!$brand){
            abort(404);
        }

        $brand->delete();

        return redirect('admin/brands')->with(['success-message' => 'Бренд успішно видалено.']);
    }
}
