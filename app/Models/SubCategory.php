<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'name',
        'seo_name',
        'active',
        'category_id'
    ];
    public function products() {
        return $this->hasMany('App\Models\Product', 'category_sub_id', 'id');
    }

    public function categories(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
}
