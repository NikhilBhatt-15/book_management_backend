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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('book_id');
            // $table->foreignId('cart_id')->constrained(
            //     table:'carts',indexName:'id'
            // )->onDelete('cascade');
            
            
            // $table->foreignId('book_id')->constrained(table:'books',indexName:'id')->onDelete('cascade');
            $table->integer('quantity');
            $table->foreign('book_id','fk_book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('cart_id','fk_cart_id')->references('id')->on('carts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
