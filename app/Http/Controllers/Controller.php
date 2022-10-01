<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CategoryGroup;
use App\Models\ProductBrand;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductMaterial;
use App\Models\ProductSeason;
use App\Models\ProductSize;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
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
     * Сео имя группы категорий
     * @var string
     */
    protected string $group_seo_name;

    /**
     * Сео имя категории
     * @var string
     */
    protected string $category_seo_name;

    /**
     * Сео имя под-категории
     * @var string
     */
    protected string $sub_category_seo_name;

    /**
     * Сео имя продукта
     * @var string
     */
    protected string $product_seo_name;

    /**
     * Сео имя баннера
     * @var string
     */
    protected  string $banner_seo_name;

    /**
     * Пользователь
     * @var Authenticatable|null
     */
    protected Authenticatable|null $user;

    /**
     * Массив данных для вьюхи
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
     * Получение авторизованого пользователя
     * @return Authenticatable|null
     */
    public function user(): Authenticatable|null
    {
        return Auth::check() ? Auth::user() : null;
    }

    /**
     * Получение авторизованого пользователя
     * @return int|null
     */
    public function userId(): int|null
    {
        return Auth::check() ? Auth::id() : null;
    }

    /**
     * Получение всех брендов группы категорий, у которых есть продукты
     *
     * @param int $group_id
     * @return array|null
     */
    public function getGroupBrands(int $group_id): array|null
    {
        //TODO
        $brands = ProductBrand::query()->where('active', 1)->get();
        foreach ($brands as $brand) {
            foreach ($brand->products as $brand_product){
                if($brand_product->category_group_id == $group_id){
                    $group_brands[] = $brand;
                    break;
                }
            }
        }

        return $group_brands ?? null;

    }

    /**
     * получение корзины
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
     * Получение корзины по токену сессии
     *
     * @return Model|Builder|null
     */
    public function getCartByToken(): Model|Builder|null
    {
        return Cart::getByToken();
    }

    /**
     * Получение базовых данных для страниц ошибок и тп
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
     * Получаем массив со свойствами продуктов
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
            'colors' => ProductColor::query()->where('active', 1)->get(),
            "materials"=> ProductMaterial::query()->where('active', 1)->get(),
            "seasons" => ProductSeason::query()->where('active', 1)->get(),
            "sizes" => ProductSize::query()->where('active', 1)->get(),
            "images"=> ProductImage::all(),
        ];
    }

    /**
     * Получение идентификатора сессии или юзера
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
