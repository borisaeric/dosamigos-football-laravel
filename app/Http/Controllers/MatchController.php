<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Match;
use App\Season;
use App\Club;
use App\Http\Resources\MatchResource;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($season_id)
    {
        // Get season
        $season = Season::findOrFail($season_id);

        // Get all matches
        $matches = $season->matches;
        
        // Return matches as collection of resources
        return MatchResource::collection($matches);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $season_id)
    {
        $season = Season::findOrFail($season_id);
        $request->request->add(['season_id' => $season_id]);

        $home_club_id = $request->input('home_club_id');
        $away_club_id = $request->input('away_club_id');
        $home_club_score = $request->input('home_club_score');
        $away_club_score = $request->input('away_club_score');

        $home_club = $season->clubs->where('id', $home_club_id)->first();
        $away_club = $season->clubs->where('id', $away_club_id)->first();
        $match = $season->matches->where('season_id', $season_id)->where('home_club_id', $home_club_id)->where('away_club_id', $away_club_id)->first();

        $message = null;
        if(!is_null($match))
        {
            $message = 'Match already exists!';
        }

        if(is_null($home_club))
        {
            $message = 'Home club does not exists in this season!';

        }
        if(is_null($away_club))
        {
            $message = 'Away club does not exists in this season!';
        }
        if($home_club_id == $away_club_id)
        {
            $message = 'Club cannot play against itself';
        }
        if(!is_null($message))
        {
            return response()->json([
                'error' => $message
            ], 422);
        }

        // Validation, if fails it throws exception
        $request->validate([
            'home_club_id' => 'required|integer|min:0',
            'away_club_id' => 'required|integer|min:0',
            'home_club_score' => 'required|integer|min:0',
            'away_club_score' => 'required|integer|min:0'
        ]);

        $match = new Match;
        
        $match->season_id = $season_id;
        $match->home_club_id = $home_club_id;
        $match->away_club_id = $away_club_id;
        $match->home_club_score = $home_club_score;
        $match->away_club_score = $away_club_score;

        if($match->save()) {
            $match->add_stats_to_match(1);
            return new MatchResource($match);
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($season_id, $id)
    {
        // Get season
        $season = Season::findOrFail($season_id);

        // Get match
        $match = $season->matches->where('id', $id)->first();

        // Return match as single resource
        return new MatchResource($match);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($season_id, $id)
    {
        // Get season
        $season = Season::findOrFail($season_id);
        
        // Get match
        $match = $season->matches->where('id', $id)->first();

        if($match->delete())
        {
            return response()->json([], 204);
        }
    }
}
