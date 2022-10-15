<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromocodeRequest;
use App\Models\Promocode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class PromocodeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|string
     */
    public function index(): View|Factory|string|Application
    {
        $this->canSee('content');

        $promocodes = Promocode::query()->orderBy('id', 'desc')->paginate(5);

        if(request()->ajax()){
            return view('admin.promocode.ajax.pagination', compact('promocodes'))->render();
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.promocode.index', [
            'promocodes' => $promocodes,
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

        $breadcrumbs[] = ["Промокоди"];

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

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('promocodes',true));

        return view('admin.promocode.add',[
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PromocodeRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(PromocodeRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $request->setMinimalPromocodeConditionsFields();

        $request->setActiveField();

        Promocode::query()->create($request->all());

        return redirect('/admin/promocodes')->with(['success-message' => 'Промокод успішно додано.']);
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

        $promocode = Promocode::find($id);

        if(!$promocode){
            abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('promocodes',false));

        return view('admin.promocode.edit', [
            'promocode' => $promocode,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PromocodeRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(PromocodeRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('content');

        $promocode = Promocode::query()->find($id);

        if(!$promocode){
            abort(404);
        }

        $request->setMinimalPromocodeConditionsFields();

        $request->setActiveField();

        $promocode->update($request->all());

        return redirect("/admin/promocodes")->with(['success-message' => 'Промокод успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $this->canDelete('content');

        $promocode = Promocode::query()->find($id);

        if(!$promocode){
            abort(404);
        }

        $promocode->delete();

        return redirect("/admin/promocodes")->with(['success-message' => 'Промокод успішно видалено.']);
    }
}
