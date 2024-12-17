<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_vouchers', function (Blueprint $table) {
            $table->id();
            $table->text('unique_id');
            $table->date('date');
            $table->date('cheque_date')->nullable();
            $table->unsignedBigInteger('buyer')->nullable();
            $table->unsignedBigInteger('seller')->nullable();
            $table->unsignedBigInteger('sales_officer')->nullable();
            $table->unsignedBigInteger('farm')->nullable();
            $table->text('ref_no')->nullable();
            $table->text('remark')->nullable();
            $table->text('narration');
            $table->text('cash_bank')->nullable();
            $table->text('cheque_no')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('amount_total', 15, 2);
            $table->text('attachment')->nullable();
            $table->timestamps();

            // $table->foreign('buyer')->references('buyer_id')->on('buyer')->restrictOnDelete();
            // $table->foreign('seller')->references('seller_id')->on('seller')->restrictOnDelete();
            $table->foreign('sales_officer')->references('sales_officer_id')->on('sales_officer')->restrictOnDelete();
            $table->foreign('farm')->references('id')->on('farms')->restrictOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_vouchers');
    }
}
