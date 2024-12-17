<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChickInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chick_invoices', function (Blueprint $table) {
            $table->id();
            $table->text('unique_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('item');
            $table->date('date');
            $table->unsignedBigInteger('sales_officer')->nullable();
            $table->unsignedBigInteger('farm')->nullable();
            $table->unsignedBigInteger('buyer');
            $table->unsignedBigInteger('seller');
            $table->text('remark')->nullable();

            $table->decimal('rate', 15, 2);
            $table->decimal('qty', 15, 2);
            $table->decimal('discount', 15, 2);
            $table->decimal('bonus', 15, 2);
            $table->decimal('amount', 15, 2);

            $table->decimal('sale_rate', 15, 2);
            $table->decimal('sale_qty', 15, 2);
            $table->decimal('sale_discount', 15, 2);
            $table->decimal('sale_bonus', 15, 2);
            $table->decimal('sale_amount', 15, 2);

            $table->decimal('qty_total', 15, 2);
            $table->decimal('amount_total', 15, 2);
            $table->decimal('sale_qty_total', 15, 2);
            $table->decimal('sale_amount_total', 15, 2);

            $table->text('attachment')->nullable();

            $table->foreign('buyer')->references('buyer_id')->on('buyer')->restrictOnDelete();
            $table->foreign('seller')->references('buyer_id')->on('buyer')->restrictOnDelete();
            $table->foreign('sales_officer')->references('sales_officer_id')->on('sales_officer')->restrictOnDelete();
            $table->foreign('user_id')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('item')->references('product_id')->on('products')->restrictOnDelete();
            $table->foreign('farm')->references('id')->on('farms')->restrictOnDelete();

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
        Schema::dropIfExists('chick_invoices');
    }
}
