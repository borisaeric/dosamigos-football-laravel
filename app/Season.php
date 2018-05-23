<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    // Relationships on model Club
    public function clubs()
    {
        return $this->belongsToMany('App\Club', 'season_club', 'season_id', 'club_id');
    }

    // Relationships on model Match
    public function matches()
    {
        return $this->hasMany('App\Match');
    }

    // Relationships on model Standing
    public function standings()
    {
        return $this->hasMany('App\Standing');
    }
}
