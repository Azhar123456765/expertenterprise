<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();

            $table->text('unique_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('item');
            $table->date('date');
            $table->unsignedBigInteger('sales_officer')->nullable();
            $table->unsignedBigInteger('buyer')->nullable();
            $table->text('remark')->nullable();

            $table->text('unit')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('qty', 15, 2);
            $table->decimal('amount', 15, 2);

            $table->decimal('qty_total', 15, 2);
            $table->decimal('amount_total', 15, 2);
            
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('cash_receive', 15, 2);
            $table->decimal('cash_receive_account', 15, 2);
            $table->decimal('remaining_balance', 15, 2);

            $table->unsignedBigInteger('pr_item')->nullable();
            $table->string('pr_unit', 50)->nullable();
            $table->decimal('pr_qty', 15, 2)->nullable();
            $table->decimal('pr_remaining_balance', 15, 2)->nullable();

            
            $table->text('attachment')->nullable();
            $table->smallInteger('status')->default(0);

            $table->foreign('buyer')->references('buyer_id')->on('buyer')->restrictOnDelete();
            $table->foreign('sales_officer')->references('sales_officer_id')->on('sales_officer')->restrictOnDelete();
            $table->foreign('user_id')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('item')->references('product_id')->on('products')->restrictOnDelete();

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
        Schema::dropIfExists('sale_invoices');
    }
}
