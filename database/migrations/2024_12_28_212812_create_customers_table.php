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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cust_type_id')->references('id')->on('customer_types')->onDelete('cascade');
            $table->string('cust_name')->nullable();
            $table->string('cust_vat_num')->nullable();
            $table->string('cust_mobile')->nullable();
            $table->string('cust_partnership_no')->nullable();
            $table->boolean('cust_is_partnership_active')->default(false);
            $table->integer('cust_points')->default(0);
            $table->text('bill_notes')->nullable();
            $table->decimal('cust_discount', 8, 2)->default(0);
            $table->decimal('cust_balance', 10, 2)->default(0);
            $table->string('card_number')->nullable();
            $table->date('deposit_date')->nullable();
            $table->string('cust_address')->nullable();
            $table->boolean('cust_is_blacklist')->default(false);
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
        Schema::dropIfExists('customers');
    }
};
