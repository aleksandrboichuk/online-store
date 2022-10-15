<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialRequest;
use App\Models\Material;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class MaterialController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $this->canSee('content');

        $materials = Material::query()->orderBy('id', 'desc')->get();

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.additional-to-products.material.index',[
            'materials' => $materials,
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

        $breadcrumbs[] = ["Матеріали"];

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

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('materials',true));

        return view('admin.additional-to-products.material.add',[
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MaterialRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(MaterialRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $request->setActiveField();

        Material::query()->create($request->all());

        return redirect('/admin/materials')->with(['success-message' => 'Матеріал успішно додано.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id): View|Factory|Response|Application
    {
        $this->canEdit('content');

        $material = Material::query()->find($id);

        if(!$material){
            abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('materials',false));

        return view('admin.additional-to-products.material.edit', [
            'material'  => $material,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MaterialRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(MaterialRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('content');

        $material = Material::query()->find($id);

        if(!$material){
            abort(404);
        }

        $request->setActiveField();

        $material->update($request->all());

        return redirect('admin/materials')->with(['success-message' => 'Матеріал успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $this->canDelete('content');

        $material = Material::query()->find($id);

        if(!$material){
            abort(404);
        }

        return redirect('admin/materials')->with(['success-message' => 'Матеріал успішно видалено.']);
    }
}
