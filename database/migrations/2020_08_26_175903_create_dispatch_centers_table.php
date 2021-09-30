<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('emergency_center_id');
            $table->foreign('emergency_center_id')->references('id')->on('emergency_centers')->onDelete('cascade');
            $table->string('county');
            $table->string('constituency');
            $table->string('sub_county');
            $table->string('ward');
            $table->string('location');
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->string('contact');
            $table->string('open_whole_day');
            $table->string('open_public_holiday');
            $table->string('open_weekends');
            $table->string('open_late_night');
            $table->timestamps();
        });
    }

}
