<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_vouchers', function (Blueprint $table) {
            $table->id();

            $table->text('unique_id')->unique()->nullable();
            $table->text('ref_no')->nullable();
            $table->text('date')->nullable();
            $table->text('company')->nullable();
            $table->text('sales_officer')->nullable();
            $table->text('s-party')->nullable();
            $table->text('remark')->nullable();
            $table->text('narration')->nullable();
            $table->text('cheque_no')->nullable();
            $table->text('cash_bank')->nullable();
            $table->text('amount')->nullable();
            $table->text('amount_total')->nullable();



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
        Schema::dropIfExists('receipt_vouchers');
    }
}
