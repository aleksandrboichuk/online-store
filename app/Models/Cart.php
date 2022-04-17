<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        ];
    public function products(){
        return $this->belongsToMany('App\Models\Product')->withPivot('product_count', 'size');
    }

    public function user(){
        return $this->hasOne('App\Models\User');
    }
}
