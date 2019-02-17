<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    public $timestamps = true;
    protected $fillable = ['city', 'address', 'country', 'zip_code', 'first_name', 'last_name', 'phone_number'];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function orders(): HasMany
    {
        return $this->HasMany(Order::class);
    }
}