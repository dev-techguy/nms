<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyCenter extends Model
{
    public function ambulances()
    {
        return $this->hasMany(Ambulance::class);
    }
}
