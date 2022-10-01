<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\SubCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string|null $category_group
     * @return Application|Factory|View|string
     */
    public function index(Request $request, string $category_group = null): View|Factory|string|Application
    {
        if ($category_group) {

            $category_group_id = CategoryGroup::getCategoryGroupsArray()[$category_group] ?? null;

            if(!$category_group_id) {
                abort(404);
            }

            $products = Product::getListByCategoryGroup($category_group_id, 'desc', 5);

        }else{

            $products = Product::query()->orderBy('id', 'desc')->paginate(5);
        }
        if($request->ajax()){
            return view('admin.product.ajax.pagination', compact('products'))->render();
        }

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public function create(Request  $request): View|Factory|string|Application
    {
        // ajax getting categories of selected category group or subcategories of selected category
        if(request()->ajax()){

            $viewData = $this->getCategoriesOrSubcategoriesData($request);

            return view('admin.product.ajax.select-categories', $viewData)->render();
        }

        return view('admin.product.add', array_merge(
           [
               'banners'         => Banner::getActiveEntries(),
               'brands'          => ProductBrand::getActiveEntries(),
               'category_groups' => CategoryGroup::getActiveEntries(),
               'categories'      => Category::getActiveEntries(),
               'sub_categories'  => SubCategory::getActiveEntries(),
           ],
           $this->getProductProperties(),
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ProductRequest $request): Redirector|RedirectResponse|Application
    {
        $request->setActiveField();

        $request->merge([
            'discount'          => $request->get('discount') ?? 0,
            'banner_id'         => $request->get('banner')  ?? null,
            'preview_img_url'   => $request->file('preview_image')->getClientOriginalName(),
        ]);

        $product = Product::query()->create($request->all());

        // добавление картинок в хранилище и в БД
        $preview_img = $request->file('preview_image');

        $product->storeImage($preview_img, "preview");

        $product->saveAdditionalImages($request);

        $product->updateMaterials($request);

        $product->updateSizes($request);

        $product->updateProductCountField();

        return redirect('/admin/products')->with(['success-message' => 'Товар успішно додано.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(Request $request, int $id): View|Factory|Application
    {
        $product = Product::query()->find($id);

        if(!$product){
            abort(404);
        }

        // ajax на удаление картинки
        if($delete_image = $request->get('imgUrl')){
            $product->deleteImage("details", $delete_image);
        }

        $selectedMaterials =  $product->getRelationIds('materials');

        $selectedSizes =  $product->getRelationIds('sizes');

        $count_sizes = $product->getSizesCount();

        return view('admin.product.edit', array_merge(
            [
                'banners'           => Banner::getActiveEntries(),
                'brands'            => ProductBrand::getActiveEntries(),
                'category_groups'   => CategoryGroup::getActiveEntries(),
                'categories'        => Category::getActiveEntries(),
                'sub_categories'    => SubCategory::getActiveEntries(),
                'selectedMaterials' => $selectedMaterials,
                'selectedSizes'     => $selectedSizes,
                'count_sizes'       => $count_sizes,
                'product'           => $product
            ],
            $this->getProductProperties(),
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ProductRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $product = Product::query()->find($id);

        if(!$product) {
            abort(404);
        }

        $request->setActiveField();

        $preview_image = $request->file('preview_image');

        $request->merge([
            'discount'          => $request->get('discount') ?? 0,
            'banner_id'         => $request->get('banner')  ?? null,
            'preview_img_url'   => $preview_image ? $preview_image->getClientOriginalName() : $product->preview_img_url
        ]);

        $product->update($request->all());

        $product->updatePreviewImage($request);

        // if request has images which must replace some product images which it has
        $product->updateAdditionalImages($request);

        // store other images, which keys does not exist
        $product->saveAdditionalImages($request, $product->images()->count());

        $product->updateMaterials($request);

        $product->updateSizes($request);

        $product->updateProductCountField();

        return redirect("/admin/products")->with(['success-message' => 'Товар успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $product = Product::query()->find($id);

        if(!$product) {
            abort(404);
        }

        $product->deleteFolder();

        $product->delete();

        return redirect("/admin/products")->with(['success-message' => 'Товар успішно видалено.']);
    }

    /**
     * Returns categories of category group or subcategories of category by their ids
     *
     * @param Request $request
     * @return array
     */
    private function getCategoriesOrSubcategoriesData(Request $request): array
    {
        $group = $request->get('categoryGroup');
        $category = $request->get('category');

        $model = $group ? new CategoryGroup() : ($category ? new Category() : null);

        $id = $group ?? ($category ?? null);

        $relation = $group ? 'categories' : ($category ? 'subCategories' : null);

        $result = $model?->query()->find($id);

        return [
            'items' => $relation && $result ? $result->$relation()->get() : []
        ];
    }
}
