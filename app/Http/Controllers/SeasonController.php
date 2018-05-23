<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Season;
use App\Club;
use App\Standing;
use App\Http\Resources\SeasonResource;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all seasons
        $seasons = Season::all();

        // Return collection of clubs as a resource
        return SeasonResource::collection($seasons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation, if fails it throws exception
        $request->validate([
            'name' => 'required|string|unique:seasons|min:3|max:20',
            'club_ids' => 'required|array|between:2,20',
            'club_ids.*' => 'distinct|string|min:1'
        ]);

        // If club is not found it will throw not found exception
        foreach($request->club_ids as $club_id) {
            
            Club::findOrFail($club_id);
        }

        $season = new Season;

        $season->name = $request->input('name');
        $season->save();

        $clubs = $request->input('club_ids');

        foreach($clubs as $club_id) {
            $standing = new Standing;
            $standing->season_id = $season->id;
            $standing->club_id = $club_id;
            $standing->init();
            $standing->save();
        }

        $season->clubs()->sync($clubs);

        return new SeasonResource($season);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get season
        $season = Season::findOrFail($id);

        // Return season as a resource
        return new SeasonResource($season);
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
        // Validation, if fails it throws exception
        $request->validate([
            'name' => 'required|string|unique:seasons|min:3|max:20',
            'club_ids' => 'required|array|between:2,20',
            'club_ids.*' => 'distinct|string|min:1'
        ]);

        // If club is not found it will throw not found exception
        foreach($request->club_ids as $club_id) {
            
            Club::findOrFail($club_id);
        }

        $season = Season::findOrFail($id);

        $season->name = $request->input('name');
        $season->update();

        $clubs = $request->input('club_ids');

        foreach($clubs as $club_id) {
            $standing = new Standing;
            $standing->season_id = $season->id;
            $standing->club_id = $club_id;
            $standing->init();
            $standing->save();
        }

        $season->clubs()->sync($clubs);

        return new SeasonResource($season);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get single season with id from route $id
        $season = Season::findOrFail($id);

        // Try to delete season
        if($season->delete()) {
            return response()->json([],204); // Respond with status code 204
        }
    }
}
