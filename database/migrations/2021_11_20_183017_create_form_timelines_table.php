<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_timelines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('form_id');
            $table->unsignedDecimal('user_id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('timeline_by');
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
        Schema::dropIfExists('form_timelines');
    }
}
