<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChickenInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chicken_invoices', function (Blueprint $table) {
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

            $table->text('rate_type')->nullable();
            $table->text('vehicle_no')->nullable();
            $table->text('crate_type')->nullable();
            $table->decimal('crate_qty', 15, 2)->nullable();
            $table->decimal('hen_qty', 15, 2);
            $table->decimal('gross_weight', 15, 2);
            $table->decimal('actual_rate', 15, 2);

            $table->decimal('feed_cut', 15, 2);
            $table->decimal('more_cut', 15, 2);
            $table->decimal('crate_cut', 15, 2);
            $table->decimal('net_weight', 15, 2);
            $table->decimal('rate_diff', 15, 2);
            $table->decimal('rate', 15, 2);
            $table->decimal('amount', 15, 2);

            $table->decimal('sale_feed_cut', 15, 2);
            $table->decimal('sale_more_cut', 15, 2);
            $table->decimal('sale_crate_cut', 15, 2);
            $table->decimal('sale_net_weight', 15, 2);
            $table->decimal('sale_rate_diff', 15, 2);
            $table->decimal('sale_rate', 15, 2);
            $table->decimal('sale_amount', 15, 2);

            $table->decimal('avg', 15, 2);

            $table->decimal('crate_qty_total', 15, 2);
            $table->decimal('hen_qty_total', 15, 2);
            $table->decimal('gross_weight_total', 15, 2);
            $table->decimal('feed_cut_total', 15, 2);
            $table->decimal('mor_cut_total', 15, 2);
            $table->decimal('crate_cut_total', 15, 2);
            $table->decimal('n_weight_total', 15, 2);
            $table->decimal('amount_total', 15, 2);
            $table->decimal('sale_feed_cut_total', 15, 2);
            $table->decimal('sale_mor_cut_total', 15, 2);
            $table->decimal('sale_crate_cut_total', 15, 2);
            $table->decimal('sale_n_weight_total', 15, 2);
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
        Schema::dropIfExists('chicken_invoices');
    }
}
