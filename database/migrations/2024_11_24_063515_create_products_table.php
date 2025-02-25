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
            $table->string('product_ar')->nullable();
            $table->string('product_en')->nullable();

            $table->integer('brand_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('sub_brand_id')->nullable();
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->decimal('sum_purchase_price', 10, 2)->virtualAs('purchase_price * quantity');
            $table->decimal('sum_sell_price', 10, 2)->virtualAs('sell_price * quantity');
            $table->decimal('rate_profit', 10, 2)->virtualAs('sum_sell_price - sum_purchase_price');
            $table->decimal('discount', 5, 2)->default(0.00);
            $table->decimal('tax', 10, 2);
            $table->decimal('discount_sell_price', 10, 2)->virtualAs('sell_price + (sell_price * (tax / 100)) - (sell_price * (discount / 100))');
            $table->decimal('final_price_with_tax', 10, 2)->virtualAs('sell_price + (sell_price * (tax / 100)) -  (discount )');
            $table->string('barcode')->nullable();
            $table->date('product_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('photo')->nullable();

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
        Schema::dropIfExists('products');
    }
};
