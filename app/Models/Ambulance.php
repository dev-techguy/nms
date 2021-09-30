<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    public function emergency_center()
    {
        return $this->belongsTo(EmergencyCenter::class);
    }

    public function dispatch_center()
    {
        return $this->belongsTo(DispatchCenter::class);
    }
}
