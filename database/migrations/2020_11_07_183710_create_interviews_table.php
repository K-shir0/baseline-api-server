<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->bigInteger('company_information_id')->unsigned();
            $table->bigInteger('step')->unsigned();
            $table->boolean('results');
            $table->date('interview_date');

            $table->foreign('company_information_id')->references('id')->on('occupational_categories');
            $table->primary(['company_information_id', 'step']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}
