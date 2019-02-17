<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    // By default is true, but set it explicitly
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'slug',
        'publish_on',
        'stock',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'published_at'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to search posts
     */
    public function scopeSearch(Builder $query, ?string $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        }
    }

    public function scopeSearchByColumn(Builder $query, string $column, string $search)
    {
        return $query->where($column, '=', "%{$search}%");
    }

    /**
     * Scope a query to order posts by latest posted
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Return the post's Comment
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'products_tags');
    }

    static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->slug = str_slug($model->name);
            if($model->publish_on == null)
                $model->publish_on =  now();
        });

        self::updating(function ($model) {
            $model->slug = str_slug($model->name);
        });
    }
}