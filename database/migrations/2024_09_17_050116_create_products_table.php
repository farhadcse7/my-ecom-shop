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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade'); //for category delete cascade
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); //for category + subcategory delete cascade
            $table->integer('brand_id');
            $table->integer('unit_id');
            $table->string('name');
            $table->string('code');
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->integer('regular_price');
            $table->integer('selling_price');
            $table->integer('stock_amount');
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('image');
            $table->integer('hit_count')->default(0);
            $table->integer('sales_count')->default(0);
            $table->tinyInteger('status');
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
