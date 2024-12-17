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
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();

            $table->text('unique_id')->unique();
            $table->text('date')->nullable();
            $table->text('company')->nullable();
            $table->text('sales_officer')->nullable();
            $table->text('ref_no')->nullable();

            $table->text('remark')->nullable();
            $table->text('narration')->nullable();
            $table->text('cheque_no')->nullable();
            $table->text('cheque_date')->nullable();
            $table->text('cash_bank')->nullable();
            $table->text('amount')->nullable();
            $table->text('amount_total')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};
