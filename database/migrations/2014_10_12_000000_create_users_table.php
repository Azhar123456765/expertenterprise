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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->text('phone_number')->nullable();
            $table->text('role')->nullable();
            $table->text('access')->default('access');
            $table->text('no_records')->default('access');

            $table->text('setup_permission')->default('on');
            $table->text('finance_permission')->default('on');
            $table->text('report_permission')->default('on');
            $table->text('product_permission')->default('on');

            $table->text('last_seen')->nullable();
            
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
