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
        Schema::create('purchases', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->references('id')->on('users')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->date('date');
            $table->string('purchase_number')->unique();
            $table->longText('description');


            

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
        Schema::dropIfExists('purchases');
    }
};
