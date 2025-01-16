<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table = 'categories';

    protected $fillable = [
        'name',
        'views'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            $post->views = $post->posts()->sum('views');
        });
    }
}
