<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Searchable;
    //categories

    public function categories()
    {
        return $this->belongsTo('App\Models\Category','category_id', 'id');
    }
    public function categoryGroups()
    {
        return $this->belongsTo('App\Models\CategoryGroup','category_group_id', 'id');
    }
    public function subCategories()
    {
        return $this->belongsTo('App\Models\SubCategory','category_sub_id', 'id');
    }

//    characteristics 1:N
    public function brands()
    {
        return $this->belongsTo('App\Models\ProductBrand','product_brand_id', 'id');
    }
    public function colors()
    {
        return $this->belongsTo('App\Models\ProductColor','product_color_id', 'id');
    }
    public function seasons()
    {
        return $this->belongsTo('App\Models\ProductSeason','product_season_id', 'id');
    }

    //    characteristics N:N
    public function materials()
    {
        return $this->belongsToMany('App\Models\ProductMaterial');
    }
    public function sizes()
    {
        return $this->belongsToMany('App\Models\ProductSize');
    }

    //images
    public function images(){
        return $this->hasMany('App\Models\ProductImage');
    }

    public function carts(){
        return $this->belongsToMany('App\Models\Cart');
    }
}
