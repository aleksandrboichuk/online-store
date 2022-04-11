<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPromocode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount',
        'min_cart_total',
        'min_cart_products',
        'promocode',
        'active',
    ];

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
