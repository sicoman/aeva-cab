<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pickup_id');
            $table->unsignedBigInteger('dropoff_id');
            $table->unsignedSmallInteger('seats');
            $table->dateTime('pickup_time');
            $table->unsignedBigInteger('promo_code_id')->nullable();
            $table->enum('payment_method', ['CASH', 'CARD', 'FAWRY'])->default('CASH');
            $table->float('payable', 8, 2)->default(0);
            $table->enum('status', ['CONFIRMED','CANCELLED','REJECTED'])->default('CONFIRMED');
            $table->string('comment')->nullable();
            $table->string('response')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'pickup_time']);
            $table->index('trip_id');
            $table->index('pickup_id');
            $table->index('dropoff_id');
            $table->index('promo_code_id');
            $table->index('created_at');
            $table->index('status');

            $table->foreign('trip_id')->references('id')->on('business_trips')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pickup_id')->references('id')->on('business_trip_stations')->onDelete('cascade');
            $table->foreign('dropoff_id')->references('id')->on('business_trip_stations')->onDelete('cascade');
            $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats_trip_bookings');
    }
}