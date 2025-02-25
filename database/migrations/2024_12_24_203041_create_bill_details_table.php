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
        Schema::create ('bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->string('name');
            $table->decimal('quantity',8,2);
            $table->decimal('sell_price',8,2);
            $table->decimal('tax',8,2);
            $table->decimal('discount',8,2)->nullable();
            $table->decimal('original_tax',8,2)->nullable();
            $table->decimal('total',8,2)->nullable();


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
        Schema::dropIfExists('bill_details');
    }
};
