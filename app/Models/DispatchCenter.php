<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchCenter extends Model
{
    protected $fillable = [
        'location',
        'latitude',
        'longitude',
    ];

    public function emergency_center()
    {
        return $this->belongsTo(EmergencyCenter::class);
    }

    public function ambulance()
    {
        return $this->hasOne(Ambulance::class);
    }
}
