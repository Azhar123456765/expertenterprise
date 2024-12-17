<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmDailyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_daily_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farming_period');
            $table->unsignedBigInteger('farm');
            $table->bigInteger('hen_deaths');
            $table->bigInteger('feed_consumed');
            $table->bigInteger('water_consumed');
            $table->text('extra_expense_narration')->nullable();
            $table->bigInteger('extra_expense_amount')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->integer('status')->default(0);

            $table->foreign('user_id')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('farm')->references('id')->on('farms')->restrictOnDelete();
            $table->foreign('farming_period')->references('id')->on('farming_periods')->restrictOnDelete();

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
        Schema::dropIfExists('farm_daily_reports');
    }
}
