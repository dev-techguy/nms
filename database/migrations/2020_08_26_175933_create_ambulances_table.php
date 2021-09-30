<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dispatch_center_id');
            $table->integer('basic_stats');
            $table->integer('advanced_stats');
            $table->integer('EMTs_stats');
            $table->integer('driver_stats');
            $table->integer('shift_stats');
            $table->integer('staff_per_shift_stats');
            $table->boolean('gps_enabled')->default(0);
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
        Schema::dropIfExists('ambulances');
    }
}
