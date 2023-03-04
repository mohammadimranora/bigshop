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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User Id');
            $table->string('order_number', 100)->comment("Order Number");
            $table->float('discount', 8, 2)->comment('Discount Amount');
            $table->float('total', 8, 2)->comment('Total Amount');
            $table->enum('payment_method', ['ONLINE', 'COD'])->comment('Payment Method');
            $table->enum('payment_status', ['PENDING', 'CONFIRMED'])->comment('Payment Status');
            $table->enum('status', ['PENDING', 'CONFIRMED', 'PROCESSING', 'COMPLETED'])->comment('Order Status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
