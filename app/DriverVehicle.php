<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverVehicle extends Model
{
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * The services that belong to the user.
     */
    public function driver()
    {
        return $this->belongsTo('App\Driver', 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }
}
