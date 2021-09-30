<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id');
            $table->foreignId('vehicle_id');
            $table->text('task_name');
            $table->string('status');
            $table->integer('tracker_object_id')->nullable();
            $table->string('start_lat')->nullable();
            $table->string('start_long')->nullable();
            $table->string('end_lat')->nullable();
            $table->string('end_long')->nullable();
            $table->foreignId('incident_id')->nullable();
            $table->foreignId('emt_id')->nullable();
            $table->foreignId('nurse_id')->nullable();
            $table->dateTime('pick_time')->nullable();
            $table->dateTime('facility_arrival_time');
            $table->text('challenges')->nullable();
            $table->text('comments')->nullable();
            $table->string('guest_nurse_name')->nullable();
            $table->string('guest_nurse_phone')->nullable();
            $table->string('guest_nurse_id_number')->nullable();
            $table->dateTime('cancelled_on')->nullable();
            $table->dateTime('accepted_on')->nullable();
            $table->dateTime('completed_on')->nullable();
            $table->dateTime('rejected_on')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
