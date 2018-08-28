<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateleaveHistorytable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('snk_no');
            $table->string('leave_no');
            $table->string('leave_from');
            $table->string('leave_till');
            $table->string('reason');
            $table->string('in_process');
            $table->string('is_approve');
            $table->string('is_read');
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
        Schema::dropIfExists('leave_history');
    }
}
