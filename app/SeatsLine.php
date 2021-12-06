<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeatsLine extends Model
{
    protected $guarded = [];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function stations() 
    {        
        return $this->hasMany(SeatsLineStation::class, 'line_id');
    }

    public function scopePartner($query, $args) 
    {
        if (array_key_exists('partner_id', $args) && $args['partner_id'])
            $query->where('partner_id', $args['partner_id']);
        
 
        return $query;
    }

    public function scopeSearch($query, $args) 
    {
        if (array_key_exists('searchQuery', $args) && $args['searchQuery'])
            $query = $this->search($args['searchFor'], $args['searchQuery'], $query);

        return $query->latest();
    }

    public function scopeCity($query, $args) 
    {
        if (array_key_exists('city_id', $args) && $args['city_id']) {
            return $query->where('city_id', $args['city_id']);
        }
 
        return $query;
    }
}
