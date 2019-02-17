<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends FileUpload
{
    protected $table = 'file_uploads';
    protected $fillable = ['file_name', 'file_path', 'original_name', 'product_id'];

    protected function product(): BelongsTo
    {
        $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('product_image', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('type', ProductImage::class);
        });

        static::creating(function ($productImage) {
            $productImage->type = ProductImage::class;
        });
    }

}