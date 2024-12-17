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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id('buyer_id');
            $table->text('company_name')->nullable();
            $table->email('company_name')->nullable();
            $table->text('credit')->default('0.00');
            $table->text('debit')->default('0.00');
            $table->text('buyer_type')->default('1');
            $table->text('city')->nullable();
            $table->text('address')->nullable();
            $table->text('company_phone_number')->nullable();
            $table->text('contact_person')->nullable();
            $table->text('contact_person_phone')->nullable();
            $table->text('contact_person_number')->nullable();
            $table->text('total_records')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
