<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{

    protected $fillable = ['product_id', 'name', 'slug', 'price', 'quantity'];

    function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}