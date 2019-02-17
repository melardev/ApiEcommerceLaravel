<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryImage extends FileUpload
{

    protected $table = 'file_uploads';
    protected $fillable = ['file_name', 'file_path', 'original_name', 'category_id'];

    protected function category(): BelongsTo
    {
        $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('category_image', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('type', CategoryImage::class);
        });

        static::creating(function ($categoryImage) {
            $categoryImage->type = CategoryImage::class;
        });
    }
}