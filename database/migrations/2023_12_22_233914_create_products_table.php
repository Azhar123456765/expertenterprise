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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->text('product_name')->unique_id();
            $table->text('desc')->nullable();
            $table->text('company')->nullable();
            $table->text('product_type')->nullable();
            $table->text('category')->nullable();
            $table->text('purchase_price')->nullable();
            $table->text('product_sale_price')->nullable();
            $table->text('opening_pur_price')->default('0.00');
            $table->text('opening_quantity')->default('0.00');
            $table->text('avg_pur_price')->nullable();
            $table->text('overhead_exp')->nullable();
            $table->text('overhead_price_pur')->nullable();
            $table->text('overhead_price_avg')->nullable();
            $table->text('pur_price_plus_oh')->nullable();
            $table->text('avg_price_plus_oh')->nullable();
            $table->text('inactive_item')->nullable();
            $table->text('barcode')->nullable();
            $table->text('qr_code')->nullable();
            $table->text('unit')->nullable();
            $table->text('re_order_level')->nullable();
            $table->text('image')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
