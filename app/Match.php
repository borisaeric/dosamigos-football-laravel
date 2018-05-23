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

    public function add_stats_to_match($add_or_delete)
    {
        $season = Season::findOrFail($this->season_id);
        $standing_home = $season->standings->where('club_id', $this->home_club_id)->first();
        $standing_away = $season->standings->where('club_id', $this->away_club_id)->first();
        
        if($this->home_club_score > $this->away_club_score) {
            $standing_home->match_score("win", $this->home_club_score, $this->away_club_score, $add_or_delete);
            $standing_away->match_score("defeat", $this->away_club_score, $this->home_club_score, $add_or_delete);
        }
        if($this->home_club_score < $this->away_club_score) {
            $standing_home->match_score("defeat", $this->home_club_score, $this->away_club_score, $add_or_delete);
            $standing_away->match_score("win", $this->away_club_score, $this->home_club_score, $add_or_delete);
        }
        if($this->home_club_score == $this->away_club_score) {
            $standing_home->match_score("draw", $this->home_club_score, $this->away_club_score, $add_or_delete);
            $standing_away->match_score("draw", $this->away_club_score, $this->home_club_score, $add_or_delete);
        }
    }
}
