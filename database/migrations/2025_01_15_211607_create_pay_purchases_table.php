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
        Schema::create('pay_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_id');
            $table->string('bill_number');
            $table->string('paid-amount');
            $table->string('remaining-balance');
            $table->string('payment-method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_purchases');
    }
};
