<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->comment('Category Id');
            $table->string('slug', 100)->comment('Slug for the product');
            $table->string('name', 255)->comment('Product Name');
            $table->string('short_description')->nullable()->comment('Short description of the product');
            $table->text('long_description', 255)->nullable()->comment('Long description of the product');
            $table->unsignedBigInteger('view_count')->default(0)->comment('View count of product');
            $table->enum('status', [0, 1])->comment('Status of product either 0 (Inactive) or 1 (Active)');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
