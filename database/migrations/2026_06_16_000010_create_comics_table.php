<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('cover_image_path')->nullable();
            $table->string('pdf_path');
            $table->unsignedInteger('pages_count')->nullable();
            $table->unsignedSmallInteger('published_year')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};
