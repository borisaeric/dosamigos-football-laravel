<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    // Relationships on model Club
    public function home_club()
    {
        return $this->belongsTo('App\Club', 'home_club_id');
    }

    public function away_club()
    {
        return $this->belongsTo('App\Club', 'away_club_id');
    }

    // Relationships on model Season
    public function season()
    {
        return $this->belongsTo('App\Season', 'season_id');
    }
}
