<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'category_group_id',
        'seo_name',
        'description',
        'image_url',
        'mini_img_url',
        'active',
    ];

    public function categoryGroups(){
        return $this->hasMany('App\Models\CategoryGroup','id', 'category_group_id');
    }
    use HasFactory;
}
