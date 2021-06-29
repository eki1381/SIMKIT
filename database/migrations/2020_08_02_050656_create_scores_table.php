<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->decimal('volume_score', 5, 2);
            $table->decimal('time_score', 5, 2);
            $table->decimal('final_score', 5, 2);
            $table->integer('month');
            $table->integer('year');
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('user_to_id');
            $table->unsignedBigInteger('user_from_id');
            $table->unsignedBigInteger('section_id');
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
        Schema::dropIfExists('scores');
    }
}
