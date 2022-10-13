<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Models\CategoryGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BannerController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @param string|null $category_group_seo_name
     * @return Application|Factory|View
     */
    public function index(string $category_group_seo_name = null): Application|Factory|View
    {
        $this->canSee('content');

        if ($category_group_seo_name) {

            $category_group_id = CategoryGroup::getCategoryGroupsArray()[$category_group_seo_name] ?? null;

            if(!$category_group_id) {
               abort(404);
            }

            $banners = Banner::getListByCategoryGroup($category_group_id, 'desc');
        }else{

            $banners = Banner::query()->orderBy('id', 'desc')->get();
        }

        return view('admin.banner.index',[
            'banners' => $banners,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        $this->canCreate('content');

        return view('admin.banner.add',[
            'category_groups' => CategoryGroup::getActiveEntries(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BannerRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $image = $request->file('image');

        $request->setActiveField();

        $request->merge([
            'image_url' => $image->getClientOriginalName()
        ]);

        $banner = Banner::query()->create($request->all());

        $banner->saveImage($image);

        return redirect('/admin/banners')
            ->with(['success-message' => 'Банер успішно додано.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id): View|Factory|Application
    {
        $this->canEdit('content');

        $banner = Banner::query()->find($id);

        if(!$banner){
            abort(404);
        }

        return view('admin.banner.edit',[
            'banner'          => $banner ,
            'category_groups' => CategoryGroup::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BannerRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(BannerRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('content');

        $banner = Banner::query()->find($id);

        if(!$banner)
        {
            abort(404);
        }

        if($image = $request->file('image')){
            $banner->updateImageInStorage($image);
        }

        $request->setActiveField();

        $request->merge([
            'image_url' => $image ? $image->getClientOriginalName() : $banner->image_url
        ]);

        $banner->update($request->all());

        return redirect("/admin/banners")->with(['success-message' => 'Банер успішно змінено.']);
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

        $banner = Banner::query()->find($id);

        if(!$banner) {
            abort(404);
        }

        $banner->delete();

        $banner->deleteFolder();

        return redirect("/admin/banners")->with(['success-message' => 'Банер успішно видалено.']);
    }

}
