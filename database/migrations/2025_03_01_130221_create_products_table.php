<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 50);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->decimal('original_price', 15, 2);
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->integer('stock');
            $table->integer('weight');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->string('slug', 100)->unique();
            $table->timestamps();
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
