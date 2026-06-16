<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('comic_id')->constrained('comics')->restrictOnDelete();
            $table->decimal('unit_price', 10, 2);
            $table->unsignedInteger('qty')->default(1);
            $table->timestamps();

            $table->unique(['order_id','comic_id']);
            $table->index('comic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
