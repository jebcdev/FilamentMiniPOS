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
        Schema::create('purchase_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('purchase_id')->references('id')->on('purchases')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->foreignId('product_id')->references('id')->on('products')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('purchase_details');
    }
};
