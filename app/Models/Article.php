<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'image_path', 'slug', 'views'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function ($article) {
            $article->slug = $article->generateUniqueSlug();
        });

        static::updating(function ($article) {
            if ($article->isDirty('title')) {
                $article->slug = $article->generateUniqueSlug();
            }
        });
    }

   // App/Models/Article.php

public function generateUniqueSlug()
{
    $base = $this->title ? Str::slug($this->title) : 'artikel';
    $slug = $base;
    $count = 0;

    // Cek duplikat, skip diri sendiri saat update
    while (static::where('slug', $slug)
            ->where('id', '!=', $this->id ?? 0)
            ->exists()) {
        $count++;
        $slug = $base . '-' . $count;
    }

    return $slug;
}
}