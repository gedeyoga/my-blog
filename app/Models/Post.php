<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, SoftDeletes , InteractsWithMedia;

    protected $fillable = [
        'slug', 'title', 'article', 'status', 'created_by'
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id' , 'category_id');
    }

    public static function booted()
    {
        parent::boot();
        
        $auth = Auth::user();
        static::creating(function ($model) use ($auth) {
            $model->slug = Str::slug($model->title);
            $model->created_by =  $auth->id;
        });
        static::updating(function ($model) use ($auth) {
            $model->slug = Str::slug($model->title);
        });
    }

    public function user_created()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function post_category() {
        return $this->hasMany(PostCategory::class , 'post_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail_post')->singleFile();
    }
}
