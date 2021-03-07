<?php

namespace App;

use App\PartnerDriver;
use App\Traits\Searchable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class Driver extends Authenticatable implements JWTSubject
{
    use Notifiable, Searchable;
    
    protected $guarded = [];

    protected $hidden = ['password'];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @param  string  $type
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, "drivers"));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function trips()
    {
        return $this->hasMany(BusinessTrip::class);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'driver_vehicles');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function deviceTokens()
    {
        return $this->morphMany(DeviceToken::class, 'tokenable');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function scopeFilterByFleet($query, $args) 
    {
        if (array_key_exists('fleet_id', $args) && $args['fleet_id']) {
            $query->where('fleet_id', $args['fleet_id']);
        }

        return $query->orderBy('created_at', 'DESC');
    }

    public function scopeNotAssigned($query, $args) 
    {
        $partnerDrivers = PartnerDriver::where('partner_id', $args['partner_id'])->pluck('driver_id');

        return $query->whereNotIn('id', $partnerDrivers)
            ->orderBy('created_at', 'DESC');
    }

    public function scopeSearch($query, $args) 
    {
        
        if (array_key_exists('searchQuery', $args) && $args['searchQuery']) {
            $query = $this->search($args['searchFor'], $args['searchQuery'], $query);
        }

        return $query;
    }

    public static function updateLocation(string $lat, string $lng)
    {
        try {
            auth('driver')
                ->userOrFail()
                ->update(['latitude' => $lat, 'longitude' => $lng]);
        } catch (UserNotDefinedException $e) {
            //
        }
    }
} 
