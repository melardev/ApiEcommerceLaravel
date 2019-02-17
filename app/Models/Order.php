<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    const status_choices = [
        0 => 'ordered',
        1 => 'in_transit',
        2 => 'delivered'
    ];
    protected $fillable =['address_id'];

    function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Return the comment's author
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function totalPrice()
    {
        $price = 0.0;
        foreach ($this->orderItems as $orderItem)
            $price += (int)$orderItem->price;

        return $price;
    }
}

?>