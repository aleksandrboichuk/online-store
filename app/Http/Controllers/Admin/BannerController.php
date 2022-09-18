<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Models\CategoryGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        if ($category_group_seo_name) {

            $category_group_id = CategoryGroup::getCategoryGroupsArray()[$category_group_seo_name] ?? null;

            if(!$category_group_id) {
               abort(404);
            }

            $banners = Banner::getListOfBanners($category_group_id, 'desc');
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
        $image = $request->file('image');

        $request->setActiveField();

        $request->merge([
            'image_url' => $image->getClientOriginalName()
        ]);

        $banner = Banner::query()->create($request->all());

        $this->saveBannerImage($banner->id, $image);

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
        $banner = Banner::query()->find($id);

        if(!$banner)
        {
            abort(404);
        }

        if($image = $request->file('image')){
            $this->updateBannerImageInStorage($banner, $image);
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
        $banner = Banner::query()->find($id);

        if(!$banner) {
            abort(404);
        }

        $banner->delete();

        $this->deleteBannerFolder($id);

        return redirect("/admin/banners")->with(['success-message' => 'Банер успішно видалено.']);
    }


    /**
     * Saving banner image to storage
     *
     * @param int $banner_id
     * @param UploadedFile $image
     * @return void
     */
    private function saveBannerImage(int $banner_id, UploadedFile $image): void
    {
        (bool)Storage::disk('banners')->putFileAs($banner_id, $image, $image->getClientOriginalName());
    }


    /**
     * Deleting old and saving new file image of banner in storage
     *
     * @param Model $banner
     * @param UploadedFile $image
     * @return void
     */
    private function updateBannerImageInStorage(Model $banner, UploadedFile $image): void
    {
        $this->deleteOldBannerImage($banner);
        Storage::disk('banners')->putFileAs($banner->id, $image, $image->getClientOriginalName());
    }

    /**
     * Deleting old banner image in storage
     *
     * @param Model $banner
     * @return void
     */
    private function deleteOldBannerImage(Model $banner): void
    {
        Storage::disk('banners')->delete($banner->id . '/' . $banner->image_url);
    }

    /**
     * Deleting old banner image in storage
     *
     * @param int $banner_id
     * @return void
     */
    private function deleteBannerFolder(int $banner_id): void
    {
        Storage::disk('banners')->deleteDirectory($banner_id);
    }
}
