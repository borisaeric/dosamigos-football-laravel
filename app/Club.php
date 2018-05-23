<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    // Relationships on model Season
    public function seasons()
    {
        return $this->belongsToMany('App\Season', 'season_club', 'club_id', 'season_id');
    }

    // Relationships on model Match
    public function home_matches()
    {
        return $this->hasManyThrough('App\Match', 'App\Season', 'home_club_id', 'season_id', 'id', 'id');
    }
    public function away_matches()
    {
        return $this->hasManyThrough('App\Match', 'App\Season', 'away_club_id', 'season_id', 'id', 'id');
    }

    // Relationships on model Standing
    public function standings()
    {
        return $this->hasMany('App\Standing');
    }
}
