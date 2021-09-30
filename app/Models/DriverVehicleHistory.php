<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DriverVehicleHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 'vehicle_id', 'phone', 'check_in', 'check_out'
    ];

    /**
     * Get the driver
     */
    public function driver()
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


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            }
        });
        static::updating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_by = $user->id;
            }
        });
    }
}
