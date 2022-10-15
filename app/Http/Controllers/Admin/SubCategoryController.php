<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class SubCategoryController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $this->canSee('content');

        $subcategories =  SubCategory::query()->orderBy('id', 'desc')->get();

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.subcategory.index', [
            'subcategories' => $subcategories,
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

        $breadcrumbs[] = ["Підкатегорії"];

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

        $categories = Category::getActiveEntries();

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('subcategories',true));

        return view('admin.subcategory.add',[
            'categories' => $categories,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubCategoryRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SubCategoryRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $request->setActiveField();

        SubCategory::query()->create($request->all());

        return redirect('/admin/subcategories')->with(['success-message' => 'Підкатегорію успішно додано.']);
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

        $subcategory = SubCategory::query()->find($id);

        if(!$subcategory){
           abort(404);
        }

        $categories = Category::getActiveEntries();

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('subcategories',false));

        return view('admin.subcategory.edit', [
            'subcategory'   => $subcategory,
            'categories'    => $categories,
            'breadcrumbs'   => $this->breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubCategoryRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(SubCategoryRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('content');

        $subcategory = SubCategory::query()->find($id);

        if(!$subcategory){
            abort(404);
        }

        $request->setActiveField();

        $active = $request->get('active');

        if($subcategory->active != $active){
            $this->setActiveFieldToModelRelations($subcategory, $active, ['products']);
        }


        $subcategory->update($request->all());

        return redirect("/admin/subcategories")->with(['success-message' => 'Підкатегорію успішно змінено.']);
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

        $subcategory = SubCategory::query()->find($id);

        if(!$subcategory){
            abort(404);
        }

        $subcategory->delete();
        return redirect("/admin/subcategories")->with(['success-message' => 'Підкатегорію успішно видалено.']);
    }
}
