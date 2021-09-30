<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'id_number',
        'is_watcher',
        'is_dispatcher',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    /**
     * Get the driver's vehicle.
     *
     * public function vehicle() {
     * return $this->hasOne('App\Models\DriverVehicle', 'driver_id');
     * }*/

    /**
     * Get the driver's vehicles.
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany('App\Models\DriverVehicle', 'driver_id');
    }

    /**
     * Get the driver's vehicles history.
     */
    public function vehiclesHistory(): HasMany
    {
        return $this->hasMany('App\Models\DriverVehicleHistory', 'driver_id');
    }

    /**
     * Get the driver's tasks.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany('App\Models\Task', 'driver_id');
    }

    /**
     * get report
     * @return HasOne
     */
    public function report(): HasOne
    {
        return $this->hasOne(Report::class);
    }
}
