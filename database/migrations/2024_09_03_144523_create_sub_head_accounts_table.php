<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubHeadAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_head_accounts', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->unsignedBigInteger('head');
            $table->timestamps();

            $table->foreign('head')->references('id')->on('head_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_head_accounts');
    }
}
