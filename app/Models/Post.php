<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'name',
        'slug',
        'content',
        'posted_date',
        'poster_image',
        'is_published',
        'meta_title',
        'meta_description',
    ];

    protected $guarded = [];

    protected $dates = [
        'posted_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    public function storeMedia($media, $type = 'images', $key): void
    {
        if (!$media) {
            return; // Handle empty video gracefully
        }

        $path = Storage::disk('public')->put($type, $media);
        $this->$key = $path;
        $this->save();
    }

    public function deleteMedia($key): void
    {
        if (!Storage::disk('public')->exists($key)) {
            return; // Handle non-existent image
        }

        Storage::disk('public')->delete($key);
        $this->$key = null;
        $this->save();
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}
