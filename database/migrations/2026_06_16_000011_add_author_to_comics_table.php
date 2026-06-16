<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->string('author', 160)->nullable()->after('slug');
            $table->index('author');
        });
    }

    public function down(): void
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->dropIndex(['author']);
            $table->dropColumn('author');
        });
    }
};
