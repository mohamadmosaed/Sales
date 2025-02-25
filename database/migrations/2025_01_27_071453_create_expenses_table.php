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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_expense')->nullable();
            $table->string('category')->nullable()->comment('فئة المصروف مثل (طعام، إيجار، مواصلات...)');
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('beneficiary')->nullable()->comment('المستفيد من المصروف (مثل: متجر، شخص)');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
