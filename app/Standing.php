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

    public function init()
    {
        $this->played_matches = 0;
        $this->wins = 0;
        $this->draws = 0;
        $this->losses = 0;
        $this->goals_scored = 0;
        $this->goals_conceded = 0;
        $this->points = 0;
    }

    public function match_score(String $result, $goals_scored, $goals_conceded, $add_or_delete)
    {
        $this->played_matches += 1*$add_or_delete;
        $this->goals_scored += $goals_scored*$add_or_delete;
        $this->goals_conceded += $goals_conceded*$add_or_delete;

        switch ($result) {
            case "win":
                $this->wins += 1*$add_or_delete;
                $this->points += 3*$add_or_delete;
                break;
            case "draw":
                $this->draws += 1*$add_or_delete;
                $this->points += 1*$add_or_delete;
                break;
            case "defeat":
                $this->losses += 1*$add_or_delete;
                break;
        }

        $this->save();
    }
}
