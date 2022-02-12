<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{

    use HasFactory;
    public function products() {
        return $this->hasMany('App\Models\Product', 'category_group_id', 'id');
    }
    public function categories() {
        return $this->belongsToMany('App\Models\Category');
    }
}
