<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryGroupRequest;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\CategoryGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CategoryGroupController extends AdminController
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

        return view('admin.category-group.index',[
            'category_groups' => CategoryGroup::query()->orderBy('id', 'desc')->get(),
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

        $breadcrumbs[] = ["Групи категорій"];

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

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('category-groups',true));

        return view('admin.category-group.add',[
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryGroupRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CategoryGroupRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $request->setActiveField();

        CategoryGroup::query()->create($request->all());

        return redirect('/admin/category-groups')->with(['success-message' => 'Групу категорій успішно додано.']);
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

        $category_group =  CategoryGroup::query()->find($id);

        if(!$category_group){
            abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('category-groups',false));

        return view('admin.category-group.edit',[
            'category_group' => $category_group,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param CategoryGroupRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(CategoryGroupRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('content');

        $category_group = CategoryGroup::query()->find($id);

        $request->setActiveField();

        $category_group->update($request->all());

        return redirect("/admin/category-groups")->with(['success-message' => 'Групу категорій успішно змінено.']);
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

        $category_group = CategoryGroup::query()->find($id);

        if(!$category_group){
            abort(404);
        }

        $category_group->delete();

        return redirect("/admin/category-groups")->with(['success-message' => 'Групу категорій успішно видалено.']);
    }
}
