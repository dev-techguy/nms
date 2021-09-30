<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('watcher_id');
            $table->foreignId('dispatcher_id')->nullable();
            $table->string('case_number')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->string('location')->nullable();
            $table->string('location_lat')->nullable();
            $table->string('location_long')->nullable();
            $table->string('alert_mode')->nullable();
            $table->text('channel')->nullable();
            $table->integer('mass_casualty_cases')->nullable();
            $table->text('notifier_phone')->nullable();
            $table->string('alert_nature')->nullable();
            $table->string('estate_health_facility')->nullable();
            $table->string('patient_name')->nullable();
            $table->integer('patient_age')->nullable();
            $table->string('patient_gender')->nullable();
            $table->string('patient_nhif_insurance_data')->nullable();
            $table->string('patient_contact')->nullable();
            $table->string('patient_next_of_kin')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('facility_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('hospital_level')->nullable();
            $table->string('sub_county')->nullable();
            $table->text('pre_hospital_management')->nullable();
            $table->string('alternative_health_facility')->nullable();
            $table->text('dispatcher_challenges')->nullable();
            $table->text('dispatcher_comments')->nullable();
            $table->string('mass_casualty_incident')->nullable();
            $table->text('watcher_comments')->nullable();
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
        Schema::dropIfExists('incidents');
    }
}
