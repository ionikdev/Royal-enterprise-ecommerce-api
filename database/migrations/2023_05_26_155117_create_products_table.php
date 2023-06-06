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
            $table->integer('category_id');
            $table->string('slug');
            $table->string('name');
            $table->string('brand');
            $table->string('quantity');
            $table->string('image')->nullable();
            $table->string('sellingPrice');
            $table->string('originalPrice');
            $table->mediumText('description')->nullable();
            $table->boolean('popular')->default(false)->nullable();
            $table->boolean('feature')->default(false)->nullable();
            $table->boolean('status')->default(false);
            
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
