<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    public function seasons()
    {
        return $this->belongsToMany('App\Season', 'season_club', 'club_id', 'season_id');
    }
}
