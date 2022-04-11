<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersList extends Model
{


    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'name',
        'email',
        'post_department',
        'city',
        'pay_now',
        'phone',
        'address',
        'comment',
        'total_cost',
        'status',
        'promocode',
    ];

    public function users(){
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }

    public function items(){
        return $this->hasMany("App\Models\OrderListItem");
    }

    public  function statuses(){
        return $this->hasMany('App\Models\StatusList', 'id', 'status');
    }
}
