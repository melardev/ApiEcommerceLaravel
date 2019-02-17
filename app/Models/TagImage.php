<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagImage extends FileUpload
{
    protected $table = 'file_uploads';
    protected $fillable = ['file_name', 'file_path', 'original_name', 'tag_id'];

    protected function tag(): BelongsTo
    {
        $this->belongsTo(Tag::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('tag_image', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->where('type', TagImage::class);
        });

        static::creating(function ($tagImage) {
            $tagImage->type = TagImage::class;
        });
    }

}