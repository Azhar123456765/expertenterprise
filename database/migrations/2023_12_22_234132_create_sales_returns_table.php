<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            $table->text('unique_id')->unique();
            $table->text('return_id')->nullable();
            $table->text('amount')->nullable();
            $table->text('sales_officer')->nullable();
            $table->text('remark')->nullable();
            $table->text('date')->nullable();
            $table->text('bilty_no')->nullable();
            $table->text('warehouse')->nullable();
            $table->text('company')->nullable();
            $table->text('type')->nullable();
            $table->text('batch_no')->nullable();
            $table->text('unit')->nullable();
            $table->text('expiry')->nullable();

            $table->text('expense_amount')->nullable();
            $table->text('discount')->nullable();
            $table->text('dis_amount')->nullable();
            $table->text('exp_unit')->nullable();
            $table->text('due_date')->nullable();
            $table->text('transporter')->nullable();
            $table->text('sale_price')->nullable();
            $table->text('sale_qty')->nullable();
            $table->text('bonus_qty')->nullable();
            $table->text('book')->nullable();
            $table->text('previous_balance')->nullable();
            $table->text('cartage')->nullable();
            $table->text('grand_total')->nullable();
            $table->text('amount_paid')->nullable();
            $table->text('balance_amount')->nullable();
            $table->text('previous_balance_amount')->nullable();
            $table->text('qty_total')->nullable();

            $table->text('amount_total')->nullable();
            $table->text('account')->nullable();
            $table->text('cash_method')->nullable();
            $table->text('previous_stock')->nullable();
            $table->text('pr_item')->nullable();
            $table->text('return_qty')->nullable();
            $table->text('dis_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_returns');
    }
};
