<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTripTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_trip_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trx_id')->nullable();
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('trip_id');
            $table->date('due_date');
            $table->float('paid', 8, 2);
            $table->enum('payment_method', ['CASH', 'CARD', 'FAWRY'])->default('CASH');
            $table->string('notes')->nullable();
            $table->enum('type', ['TOSCHOOL','TOWORK','PLAYGROUND']);
            $table->timestamps();

            $table->index('user_id');
            $table->index('trip_id');
            $table->index('created_at');
            $table->index('type');

            $table->foreign('subscription_id')->references('id')->on('business_trip_users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('business_trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_trip_transactions');
    }
}