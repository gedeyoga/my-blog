<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

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
}
