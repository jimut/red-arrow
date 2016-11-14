<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('status');

            $table->integer('donor_id')->unsigned();
            $table->foreign('donor_id')
                  ->references('id')->on('donors')
                  ->onDelete('cascade');

            $table->integer('hospital_id')->unsigned();
            $table->foreign('hospital_id')
                  ->references('id')->on('hospitals')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('appointments');
    }
}
