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
        Schema::create('supplier_bills', function (Blueprint $table) {

            $table->id();
            $table->foreignId('supplier_id')
            ->constrained('suppliers')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->date('supplier_bill_date');
            $table->decimal('supplier_bill_total', 10, 2);
            $table->decimal('supplier_bill_paid', 10, 2);
            $table->decimal('supplier_bill_remain', 10, 2);
            $table->foreignId('type_id')
            ->constrained('supplier_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('type_count');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_bills');
    }
};
