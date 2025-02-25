<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('product_ar')->nullable();
            $table->string('product_en')->nullable();
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('discount', 5, 2)->default(0.00)->nullable();
            $table->decimal('tax', 10, 2)->default(0.00)->nullable();
            $table->decimal('total', 10, 2)->virtualAs('purchase_price * quantity + (purchase_price * quantity * tax) / 100 - discount');
            $table->decimal('paid', 10, 2)->default(0.00);
            $table->decimal('remainder', 10, 2)->virtualAs('total - paid');

            $table->date('product_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE purchase_details AUTO_INCREMENT = 1000;");
    }


    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
};
