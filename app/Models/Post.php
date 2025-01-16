<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'views'
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }


    protected static function boot()
    {
        parent::boot();

        static::saved(function ($post) {
            foreach ($post->categories as $category) {
                $totalViews = $category->posts()->sum('views');
                $category->update(['views' => $totalViews]);
            }
        });
    }
}
