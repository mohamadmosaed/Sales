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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->references('id')->on('branch_names')->onDelete('cascade');
            $table->date('Invoice_date');
            $table->integer('Invoice_Number');
            $table->string('supplier_name');
            $table->string('product_serial');
            $table->string('product_ar')->nullable();
            $table->string('product_en')->nullable();
            $table->string('product_description')->nullable();
            $table->integer('stock_quantity');
            $table->integer('Reorder_level')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('barcode')->nullable();
            $table->string('Status')->nullable();
            $table->date('date_added')->nullable();
            $table->date('last_update_added')->nullable();
            $table->date('product_date')->nullable();
            $table->date('expired_date')->nullable();
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
        Schema::dropIfExists('branches');
    }
};
