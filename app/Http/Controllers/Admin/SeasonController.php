<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SeasonRequest;
use App\Models\Season;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class SeasonController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $this->canSee('content');

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.additional-to-products.season.index', [
            'seasons' => Season::query()->orderBy('id', 'desc')->get(),
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

        $breadcrumbs[] = ["Кольори"];

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

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('seasons',true));

        return view('admin.additional-to-products.season.add', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SeasonRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SeasonRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $request->setActiveField();

        Season::query()->create($request->all());

        return redirect('/admin/seasons')->with(['success-message' => 'Сезон успішно додано.']);
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

        $color = Season::query()->find($id);

        if(!$color){
            abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('seasons',false));

        return view('admin.additional-to-products.season.edit', [
            'season' => $color,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SeasonRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(SeasonRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('content');

        $color = Season::query()->find($id);

        $request->setActiveField();

        $color->update($request->all());

        return redirect('admin/seasons')->with(['success-message' => 'Сезон успішно змінено.']);
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

        $color = Season::query()->find($id);

        if(!$color) {
            abort(404);
        }

        $color->delete();

        return redirect('admin/seasons')->with(['success-message' => 'Сезон успішно видалено.']);
    }
}
