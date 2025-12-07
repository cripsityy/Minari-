<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->string('size')->nullable(); // S, M, L, XL
            $table->string('color')->nullable();
            $table->string('material')->nullable(); // Cotton, Linen, Denim, etc
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // multiple images
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['available', 'out_of_stock', 'pre_order'])->default('available');
            $table->integer('sold_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
