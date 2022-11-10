<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Color;
use App\Models\Material;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Season;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // categories
        $women = CategoryGroup::getOneBySeoName('women');
        $men = CategoryGroup::getOneBySeoName('men');

        $clothes_women = Category::getOneBySeoName('women-clothes');
        $clothes_men = Category::getOneBySeoName('men-clothes');

        $jeans_women = SubCategory::getOneBySeoName('jeans-women');
        $shirts_men = SubCategory::getOneBySeoName('shirt-men');

        // properties
        $color_blue = Color::getOneBySeoName('blue');
        $color_black = Color::getOneBySeoName('black');

        $brand_gj = Brand::getOneBySeoName('bershka');
        $brand_house = Brand::getOneBySeoName('housebrand');

        $season_summer = Season::getOneBySeoName('summer');
        $season_spring = Season::getOneBySeoName('spring');

        $size_26 = Size::getOneBySeoName('size-26');
        $size_44 = Size::getOneBySeoName('size-44');

        $material_polyester = Material::getOneBySeoName('polyester');
        $material_cotton = Material::getOneBySeoName('cotton');

        // banners
        $women_banner = Banner::getOneBySeoName('sales-10-percent');
        $men_banner = Banner::getOneBySeoName('new-men-collection');


        // products
        if($women
            && $clothes_women
            && $jeans_women
            && $color_blue
            && $brand_gj
            && $season_summer
            && $size_26
            && $material_polyester
            && $women_banner
            && Storage::disk('products')->exists('temp_images_dzhinsy-blakytni-gj')
        ){
            $jeans = Product::query()->create([
                'name' => 'Джинси Блакитні GJ',
                'seo_name' => 'dzhinsy-blakytni-gj',
                'preview_img_url' => 'dzhinsy-blakytni-gj.jpg',
                'description' => 'Джинси блакитного кольору від бренду Gloria Jeans',
                'price' => 1099,
                'discount' => 10,
                'count' => 1001,
                'in_stock' => 1,
                'active' => 1,
                'rating' => 5.0,
                'banner_id' => $women_banner->id,
                'category_group_id' => $women->id,
                'category_id' => $clothes_women->id,
                'category_sub_id' => $jeans_women->id,
                'product_color_id' => $color_blue->id,
                'product_season_id' => $season_summer->id,
                'product_brand_id' => $brand_gj->id,
            ]);

            $jeans->sizes()->attach($jeans->id, [
                'size_id' => $size_26->id,
                'count' =>  1001
            ]);

            $jeans->materials()->attach($material_polyester);

            // detail images
            for($i = 1; $i <=3; $i++){
                if(Storage::disk('products')
                    ->exists('temp_images_dzhinsy-blakytni-gj/details/dzhinsy-blakytni-gj-' . $i . '.jpg')
                ){
                    ProductImage::query()->create([
                        'url' => 'dzhinsy-blakytni-gj-' . $i . '.jpg',
                        'product_id' => $jeans->id,
                    ]);
                }
            }

            exec("mv " . public_path('/images/products/temp_images_dzhinsy-blakytni-gj') . ' ' . public_path('/images/products/' . $jeans->id));
        }


        if($men
            && $clothes_men
            && $shirts_men
            && $color_black
            && $brand_house
            && $season_spring
            && $size_44
            && $material_cotton
            && $men_banner
            && Storage::disk('products')->exists('temp_images_sorochka_chorna')
        ){
            $shirt = Product::query()->create([
                'name' => 'Сорочка чорна',
                'seo_name' => 'sorochka-chorna',
                'preview_img_url' => 'sorochka-chorna.jpg',
                'description' => 'Сорочка чорного кольору для чоловіків бренду House Brand',
                'price' => 2599,
                'discount' => 15,
                'count' => 1001,
                'in_stock' => 1,
                'active' => 1,
                'rating' => null,
                'banner_id' => $men_banner->id,
                'category_group_id' => $men->id,
                'category_id' => $clothes_men->id,
                'category_sub_id' => $shirts_men->id,
                'product_color_id' => $color_black->id,
                'product_season_id' => $season_spring->id,
                'product_brand_id' => $brand_house->id,
            ]);

            $shirt->sizes()->attach($shirt->id, [
                'size_id' => $size_44->id,
                'count' =>  1001
            ]);

            $shirt->materials()->attach($material_cotton);

            // detail images
            for($i = 1; $i <=3; $i++){
                if(Storage::disk('products')
                    ->exists('temp_images_sorochka_chorna/details/sorochka-chorna-' . $i . '.jpg')
                ){
                    ProductImage::query()->create([
                        'url' => 'sorochka-chorna-' . $i . '.jpg',
                        'product_id' => $shirt->id,
                    ]);
                }
            }
            exec("mv " . public_path('/images/products/temp_images_sorochka_chorna') . ' ' . public_path('/images/products/' . $shirt->id));
        }
    }
}
