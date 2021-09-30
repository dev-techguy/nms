<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number', 'slug', 'phone', 'device_id', 'status'
    ];


    /**
     * Get the driver for the vehicle.
     */
    public function drivers()
    {
        return $this->hasMany('App\Models\DriverVehicle');
    }

    /**
     * Get the drivers history for the vehicle.
     *
     * public function drivers() {
     * return $this->hasMany('App\Models\DriverVehicleHistory');
     * }
     *
     */

    /**
     * Get the driver for the vehicle.
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
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
