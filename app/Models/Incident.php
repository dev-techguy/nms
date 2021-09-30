<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Incident extends Model
{
    use HasFactory, HasHashSlug;

    protected $fillable = [
        'watcher_id',
        'dispatcher_id',
        'case_number',
        'chief_complaint',
        'location',
        'location_lat',
        'location_long',
        'sub_county',
        'alert_mode',
        'channel',
        'notifier_phone',
        'alert_nature',
        'estate_health_facility',
        'patient_name',
        'patient_age',
        'patient_gender',
        'patient_nhif_insurance_data',
        'patient_contact',
        'patient_next_of_kin',
        'status',
        'mass_casualty_incident',
        'watcher_comments',
        'facility_id',
        'hospital_level',
        'pre_hospital_management',
        'alternative_health_facility',
        'dispatcher_challenges',
        'dispatcher_comments',
        'mass_casualty_cases'
    ];

    //Incident Status - draft,submitted,dispatched,resolved,

    /**
     * Get the watcher
     */
    public function watcher()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    /**
     * Get the dispatcher
     */
    public function dispatcher()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    /**
     * Get the dispatcher
     */
    public function facility()
    {
        return $this->belongsTo('App\Models\Facility')->withDefault();
    }

    /**
     * Get the tasks.
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'incident_id');
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });
    }
}
