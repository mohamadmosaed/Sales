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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
           $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('sum_tax');
            $table->string('totalg')->nullable();
            $table->string('totals')->nullable();
            $table->string('discount1')->nullable();
            $table->string('discount2')->nullable();
            $table->string('charge')->nullable();
            $table->string('type');
            $table->string('cust_remark')->nullable();
            $table->string('bill_notes' )->nullable();
            $table->string('paid' )->nullable();
            $table->string('remain')->nullable();


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
        Schema::dropIfExists('bills');
    }
};
