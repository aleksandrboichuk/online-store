<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'grade',
        'review'
    ];

    public function users(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }
}
