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

            $table->foreignId('category_id')->references('id')->on('categories')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->string('code',200)->unique();
            $table->string('name',200)->unique();
            $table->longText('description')->nullable();
            $table->json('images')->nullable();

            $table->integer('stock')->default(1);
            $table->integer('min_stock')->default(1);
            $table->integer('max_stock')->default(50);

            $table->decimal('purchase_price', 12, 2);
            $table->decimal('sale_price', 12, 2);







            /*  */
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
