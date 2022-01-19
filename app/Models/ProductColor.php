<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;
    public function products(){
        return $this->hasMany('App\Models\Product','product_color_id', 'id');
    }
}
