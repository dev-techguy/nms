<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('keph_level');
            $table->string('type');
            $table->string('category');
            $table->string('ownership');
            $table->string('regulatory_body');
            $table->string('county');
            $table->string('constituency');
            $table->string('ward');
            $table->string('location')->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->string('status');
            $table->string('approved');
            $table->string('open_whole_day');
            $table->string('open_public_holiday');
            $table->string('open_weekends');
            $table->string('open_late_night');
            $table->string('contact')->nullable();
            $table->string('emergency_dpt')->nullable();
            $table->string('primary_response')->nullable();
            $table->string('inter_facility_transfer')->nullable();
            $table->string('trauma_care')->nullable();
            $table->string('stroke_care')->nullable();
            $table->string('heart_attacks')->nullable();
            $table->Integer('theater_stats')->nullable();
            $table->Integer('x_ray_stats')->nullable();
            $table->Integer('CT_stats')->nullable();
            $table->Integer('ultra_sound_stats')->nullable();
            $table->string('neurosurgeons')->nullable();
            $table->string('orthopedics_surgeons')->nullable();
            $table->timestamps();
        });
    }

}
