<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderListItem extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'price',
        'count',
        'total_cost',
        "size"
    ];

    /**
     * Relation order list - products
     *
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id', 'product_id');
    }
}
