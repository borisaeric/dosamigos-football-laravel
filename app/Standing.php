<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    // Relationships on model Club
    public function club()
    {
        return $this->belongsTo('App\Club', 'club_id');
    }

    // Relationships on model Season
    public function season()
    {
        return $this->belongsTo('App\Season', 'season_id');
    }
}
