<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'theme',
        'message',
        'user_id',
        'email',
    ];
    public function users(){
        return $this->belongsTo('App\Models\User');
    }
}
