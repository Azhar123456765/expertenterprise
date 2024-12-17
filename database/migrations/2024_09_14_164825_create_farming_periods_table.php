<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmingPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farming_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('assign_user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('assign_user_id')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('farm_id')->references('id')->on('farms')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farming_periods');
    }
}
