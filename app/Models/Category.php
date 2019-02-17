<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{
    protected $table = 'categories';

    // By default is true, but set it explicitly
    public $timestamps = true;

    protected $fillable = [
        'name', 'description'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }


    public function categoryImages(): HasMany
    {
        return $this->hasMany(CategoryImage::class);
    }

    static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->slug = str_slug($model->name);
        });

        self::updating(function ($model) {
            $model->slug = str_slug($model->name);
        });
    }
}