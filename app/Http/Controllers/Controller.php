<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CategoryGroup;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\Material;
use App\Models\Season;
use App\Models\Size;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Seo name of category group
     *
     * @var string
     */
    protected string $group_seo_name;

    /**
     * Seo name of category
     *
     * @var string
     */
    protected string $category_seo_name;

    /**
     * Seo name of subcategory
     *
     * @var string
     */
    protected string $sub_category_seo_name;

    /**
     * Seo name of product
     *
     * @var string
     */
    protected string $product_seo_name;

    /**
     * Seo name of promotion
     *
     * @var string
     */
    protected string $banner_seo_name;

    /**
     * User entry
     *
     * @var Authenticatable|null
     */
    protected Authenticatable|null $user;

    /**
     * Array with data for view
     *
     * @var array
     */
    protected array $pageData = [];

    /**
     * Page breadcrumbs
     *
     * @var array
     */
    protected array $breadcrumbs = [];

    /**
     * Returns authorized user
     *
     * @return Authenticatable|null
     */
    public function user(): Authenticatable|null
    {
        return Auth::check() ? Auth::user() : null;
    }

    /**
     * Returns authorized user id
     *
     * @return int|null
     */
    public function userId(): int|null
    {
        return Auth::check() ? Auth::id() : null;
    }

    /**
     * Returns all brands of category group which has a products
     *
     * @param int $group_id
     * @return Builder[]|Collection
     */
    public function getGroupBrands(int $group_id): Collection|array
    {
        return Brand::query()
            ->where('active', 1)
            ->whereHas('products', function (Builder $query) use ($group_id){
                return $query->where('category_group_id', $group_id);
            })
            ->get();
    }

    /**
     * Returns cart by session id or by user id
     *
     * @return mixed|null
     */
    public function getCart(): mixed
    {
        if($this->user()){
            return $this->user()->cart;
        }

        return $this->getCartByToken();

    }

    /**
     * Returns cart by session token (id)
     *
     * @return Model|Builder|null
     */
    public function getCartByToken(): Model|Builder|null
    {
        return Cart::getByToken();
    }

    /**
     * Returns basic neccessary data for every view
     *
     * @return array
     */
    #[ArrayShape([
        'user' => "\Illuminate\Contracts\Auth\Authenticatable|null",
        'cart' => "mixed"
    ])]
    public function getBasicPageData(): array
    {
        return [
          'user' => $this->user(),
          'cart' => $this->getCart() ?? null
        ];
    }

    /**
     * Returns an array with product properties
     *
     * @return array
     */
    #[ArrayShape([
        'colors' => "\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection",
        "materials" => "\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection",
        "seasons" => "\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection",
        "sizes" => "\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection",
        "images" => "\App\Models\ProductImage[]|\Illuminate\Database\Eloquent\Collection"
    ])]
    protected function getProductProperties(): array
    {
        return [
            'colors' => Color::getActiveEntries(),
            "materials"=> Material::getActiveEntries(),
            "seasons" => Season::getActiveEntries(),
            "sizes" => Size::getActiveEntries(),
            "images"=> ProductImage::all(),
        ];
    }

    /**
     * Returns user id or session id
     *
     * @return int|string
     */
    protected function getUserIdOrSessionId(): int|string
    {
        if(Auth::check()){
            return Auth::id();
        }

        return session()->getId();

    }

    /**
     * Sets a category group seo name variable
     *
     * @param string $seo_name
     * @return void
     */
    protected function setCategoryGroupSeoName(string $seo_name): void
    {
        $this->group_seo_name = $seo_name;
    }

    /**
     * Sets a category seo name variable
     *
     * @param string $seo_name
     * @return void
     */
    protected function setCategorySeoName(string $seo_name): void
    {
        $this->category_seo_name = $seo_name;
    }

    /**
     * Sets a subcategory seo name variable
     *
     * @param string $seo_name
     * @return void
     */
    protected function setSubCategorySeoName(string $seo_name): void
    {
        $this->sub_category_seo_name = $seo_name;
    }

    /**
     * Sets a product seo name variable
     *
     * @param string $seo_name
     * @return void
     */
    protected function setProductSeoName(string $seo_name): void
    {
        $this->product_seo_name = $seo_name;
    }

    /**
     * Sets a banner seo name variable
     *
     * @param string $seo_name
     * @return void
     */
    protected function setBannerSeoName(string $seo_name): void
    {
        $this->banner_seo_name = $seo_name;
    }

    /**
     * Sets a category group seo name variable
     *
     * @param Authenticatable|Model $user
     * @return void
     */
    protected function setUser(Authenticatable|Model $user): void
    {
        $this->user = $user;
    }

    /**
     * Set page breadcrumbs
     *
     * @param array $pages_arrays
     * @return void
     */
    protected function setBreadcrumbs(array $pages_arrays): void
    {
        foreach ($pages_arrays as $page_array) {
            if(count($page_array) >= 1){
                $this->breadcrumbs[] = [
                    'title' => $page_array[0],
                    'link' => $page_array[1] ?? null,
                ];
            }
        }
    }
}
