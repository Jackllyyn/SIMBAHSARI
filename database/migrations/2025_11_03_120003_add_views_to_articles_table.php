<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('slug');
        });

        // Isi nilai default 0 untuk artikel yang sudah ada
        \DB::statement('UPDATE articles SET views = 0 WHERE views IS NULL');
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};