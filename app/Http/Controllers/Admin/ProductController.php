<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductRequest;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProductController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @param string|null $category_group
     * @return Application|Factory|View|string
     */
    public function index(string $category_group = null): View|Factory|string|Application
    {
        $this->canSee('content');

        if ($category_group) {

            $category_group_id = CategoryGroup::getCategoryGroupsArray()[$category_group] ?? null;

            if(!$category_group_id) {
                abort(404);
            }

            $products = Product::getListByCategoryGroup($category_group_id, 'desc', 5);

        }else{

            $products = Product::query()->orderBy('id', 'desc')->paginate(5);
        }
        if(request()->ajax()){
            return view('admin.product.ajax.pagination', compact('products'))->render();
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.product.index', [
            'products' => $products,
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

        $breadcrumbs[] = ["Товари"];

        return $breadcrumbs;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|Factory|View|string
     */
    public function create(Request  $request): View|Factory|string|Application
    {
        $this->canCreate('content');

        $this->setBreadcrumbs(
            $this->getCreateOrEditPageBreadcrumbs('products',true)
        );

        return view('admin.product.add', $this->getCreatePageData());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ProductRequest $request): Redirector|RedirectResponse|Application
    {
        $this->canCreate('content');

        $request->setActiveField();

        $request->merge([
            'discount'          => $request->get('discount') ?? 0,
            'banner_id'         => $request->get('banner')  ?? null,
            'count'             => $this->getTotalCount($request),
            'preview_img_url'   => $request->file('preview_image')->getClientOriginalName(),
        ]);

        Product::createItem($request);

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
        $this->canEdit('content');

        $product = Product::query()->find($id);

        if(!$product){
            abort(404);
        }

        // request for deleting image
        if($delete_image = $request->get('imgUrl')){
            $product->deleteImage("details", $delete_image);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('products',false));

        return view('admin.product.edit', $this->getEditPageData($product));
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
        $this->canEdit('content');

        $product = Product::query()->find($id);

        if(!$product) {
            abort(404);
        }

        $request->setActiveField();

        $preview_image = $request->file('preview_image');

        $request->merge([
            'discount'          => $request->get('discount') ?? 0,
            'count'             => $this->getTotalCount($request),
            'banner_id'         => $request->get('banner')  ?? null,
            'preview_img_url'   => $preview_image ? $preview_image->getClientOriginalName() : $product->preview_img_url
        ]);

        $product->updateItem($request);

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
        $this->canDelete('content');

        $product = Product::query()->find($id);

        if(!$product) {
            abort(404);
        }

        $product->deleteFolder();

        $product->delete();

        return redirect("/admin/products")->with(['success-message' => 'Товар успішно видалено.']);
    }

    /**
     * Returns array with page data for creating product
     *
     * @return array|array[]|Builder[][]|Collection[]
     */
    private function getCreatePageData(): array
    {
        return array_merge(
            [
                'banners'         => Banner::getActiveEntries(),
                'brands'          => Brand::getActiveEntries(),
                'category_groups' => CategoryGroup::getActiveEntries(),
                'categories'      => Category::getActiveEntries(),
            ],
            $this->getProductProperties(),
            ['breadcrumbs' => $this->breadcrumbs]
        );
    }

    /**
     * Returns array with page data for editing product
     *
     * @param Model $product
     * @return array|array[]|Builder[][]|Collection[]
     */
    private function getEditPageData(Model $product): array
    {
        $allowedCategories = $product->categoryGroup->getActiveParentCategories();

        $productCategory = $product->category ?? null;

        $allowedNestedCategories = $productCategory?->parent?->getNestedCategories(['id', 'title']);

        return array_merge(
            [
                'banners'           => Banner::getActiveEntries(),
                'brands'            => Brand::getActiveEntries(),
                'categoryGroups'    => CategoryGroup::getActiveEntries(),
                'categories'        => $allowedCategories,
                'nestedCategories'  => $allowedNestedCategories,
                'productCategory'   => $productCategory,
                'selectedMaterials' => $product->getRelationIds('materials'),
                'selectedSizes'     => $product->getRelationIds('sizes'),
                'count_sizes'       => $product->getSizesCount(),
                'product'           => $product
            ],
            $this->getProductProperties(),
            ['breadcrumbs' => $this->breadcrumbs]
        );
    }

    /**
     * Returns total count of product by count all it's sizes
     *
     * @param ProductRequest $request
     * @return int
     */
    private function getTotalCount(ProductRequest $request): int
    {
        $sizes = $request->get('sizes');
        $sizes_count = $request->get('size-count');

        $count = 0;

        if ($sizes && $sizes_count){

            $sizes_count = array_values(array_filter($sizes_count, fn($value) => !is_null($value)));

            foreach ($sizes as $key => $size) {
                $count += $sizes_count[$key] ?? 1;
            }
        }

        return $count;
    }
}
