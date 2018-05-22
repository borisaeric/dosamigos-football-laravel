<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    public function clubs()
    {
        return $this->belongsToMany('App\Club', 'season_club', 'season_id', 'club_id');
    }
}
