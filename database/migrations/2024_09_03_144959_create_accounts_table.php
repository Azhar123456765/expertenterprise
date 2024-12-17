<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->text('account_name');
            $table->text('account_qty')->nullable();
            $table->text('account_debit')->nullable();
            $table->text('account_credit')->nullable();
            $table->unsignedBigInteger('account_category');
            $table->text('reference_id')->nullable();
            $table->timestamps();

            $table->foreign('account_category')->references('id')->on('sub_head_accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
