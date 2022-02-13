<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersList extends Model
{


    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'comment',
        'total_cost',
        'status',
    ];

    public function users(){
        return $this->belongsTo('App\Models\User');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }

    public function items(){
        return $this->hasMany("App\Models\OrderListItem");
    }
}
