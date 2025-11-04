<?php

// database/migrations/xxxx_xx_xx_fill_missing_slugs_in_articles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Article;

return new class extends Migration {
    public function up()
    {
        $articles = Article::whereNull('slug')->orWhere('slug', '')->get();

        foreach ($articles as $article) {
            $article->slug = $article->generateUniqueSlug();
            $article->saveQuietly(); // hindari trigger booted lagi
        }
    }

    public function down()
    {
        // optional
    }
};