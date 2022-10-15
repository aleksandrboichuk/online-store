<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeRequest;
use App\Models\Size;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class SizeController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $this->canSee('content');

        $sizes =  Size::query()->orderBy('id', 'desc')->get();

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.additional-to-products.size.index', [
            'sizes' => $sizes,
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

        $breadcrumbs[] = ["Розміри"];

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

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('sizes',true));

        return view('admin.additional-to-products.size.add', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SizeRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SizeRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $request->setActiveField();

        Size::query()->create($request->all());

        return redirect('/admin/sizes')->with(['success-message' => 'Розмір успішно додано.']);
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

        $size = Size::query()->find($id);

        if(!$size){
            abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('sizes',false));

        return view('admin.additional-to-products.size.edit', [
            'size' => $size,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SizeRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(SizeRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('content');

        $size = Size::query()->find($id);

        if(!$size){
            abort(404);
        }

        $request->setActiveField();

        $size->update($request->all());

        return redirect('admin/sizes')->with(['success-message' => 'Розмір успішно змінено.']);
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

        $size = Size::query()->find($id);

        if(!$size){
            abort(404);
        }

        $size->delete();

        return redirect('admin/sizes')->with(['success-message' => 'Розмір успішно видалено.']);
    }
}
