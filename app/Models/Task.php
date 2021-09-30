<?php

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory, HasHashSlug;

    protected $fillable = [
        'driver_id', 'vehicle_id', 'emergency_facility_id', 'task_name', 'status',
        'received_on', 'accepted_on', 'completed_on', 'rejected_on', 'cancelled_on',
        'tracker_object_id', 'start_lat', 'start_long', 'end_lat', 'end_long',
        'emergency_location', 'incident_id', 'emt_id', 'nurse_id', 'pick_time',
        'facility_arrival_time', 'challenges', 'comments', 'guest_nurse_name',
        'guest_nurse_id_number', 'guest_nurse_phone'
    ];

    //$status = pending|received|accepted|completed|rejected|cancelled

    /**
     * Get the driver
     */
    public function driver()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    /**
     * Get the emt
     */
    public function emt()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    /**
     * Get the nurse
     */
    public function nurse()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    /**
     * Get the vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle')->withDefault();
    }

    /**
     * Get the case
     */
    public function incident()
    {
        return $this->belongsTo('App\Models\Incident')->withDefault();
    }


    /**
     * Get the vehicle
     */
    /*public function emergencyCenter() {
        return $this->belongsTo('App\Models\Facility', 'emergency_facility_id')->withDefault();
    }*/


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
