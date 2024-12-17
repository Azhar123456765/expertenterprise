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
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            
            $table->text('unique_id')->unique();
            $table->text('user_id')->nullable();
            $table->text('sales_officer')->nullable();
            $table->text('company')->nullable();
            $table->text('remark')->nullable();
            $table->text('date')->nullable();
            $table->text('bilty_no')->nullable();
            $table->text('warehouse')->nullable();
            $table->text('book')->nullable();
            $table->text('due_date')->nullable();
            $table->text('transporter')->nullable();
            $table->text('previous_balance')->nullable();
            $table->text('cartage')->nullable();
            $table->text('grand_total')->nullable();
            $table->text('amount_paid')->nullable();
            $table->text('balance_amount')->nullable();
            $table->text('qty_total')->nullable();
            $table->text('dis_total')->nullable();
            $table->text('amount_total')->nullable();
            $table->text('invoice_no')->nullable();
            $table->text('freight')->nullable();
            $table->text('freighta')->nullable();
            $table->text('sales_tax')->nullable();
            $table->text('sales_taxa')->nullable();
            $table->text('ad_sales_tax')->nullable();
            $table->text('ad_sales_taxa')->nullable();

            $table->text('bank')->nullable();
            $table->text('banka')->nullable();
            $table->text('other_expense')->nullable();
            $table->text('other_expensea')->nullable();
            $table->text('pr_item')->nullable();
            $table->text('previous_stock')->nullable();
            $table->text('dis_amount')->nullable();
            $table->text('type')->nullable();
            $table->text('item')->nullable();
            $table->text('unit')->nullable();
            $table->text('batch_no')->nullable();

            $table->text('expiry')->nullable();
            $table->text('pur_qty')->nullable();
            $table->text('price')->nullable();
            $table->text('amount')->nullable();
            $table->text('discount')->nullable();
            $table->text('exp_unit')->nullable();
            $table->text('pur_price')->nullable();
            $table->text('bonus_qty')->nullable();
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoices');
    }
};
