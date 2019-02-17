<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{

    // By default is true, but set it explicitly
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'content',
    ];


    /**
     * Return the comment's author
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the comment's post
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}