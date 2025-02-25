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
        Schema::create('suppliers', function (Blueprint $table) {


            $table->id();
            $table->string('code')->unique();
            $table->string('name_of_company');
            $table->string('name_supplier');
            $table->string('mobile')->unique();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('supplier_vat_num')->unique()->nullable();
            $table->string('period_to_pay');
            $table->decimal('opening_balance', 10, 2)->default(0.00);
            $table->decimal('previous_balance', 10, places: 2)->default(0.00);
            $table->date('date_of_pay')->nullable();
            $table->decimal('total_paid', 10, 2)->default(0.00);
            $table->decimal('total_remain', 10, 2)->default(0.00);
            $table->decimal('supplier_balance', 10, 2)->default(0.00);
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
        Schema::dropIfExists('suppliers');
    }
};
