<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use App\Http\Resources\ClubResource;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all clubs
        $clubs = Club::all();

        // Return club as a collection of resources
        return ClubResource::collection($clubs);
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
            'name' => 'required|string|unique:clubs|min:3|max:20',
            'stadium' => 'required|string|min:3|max:20'
        ]);

        // New instance of Club model
        $club = new Club;
        
        // Assign validated input values to $club
        $club->name = $request->input('name');
        $club->stadium = $request->input('stadium');

        // Try to save club
        if($club->save()) {
            return new ClubResource($club);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get single club with id from route $id
        $club = Club::findOrFail($id);

        // Return club as a club resource
        return new ClubResource($club);
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
            'name' => 'required|string|unique:clubs|min:3|max:20',
            'stadium' => 'required|string|min:3|max:20'
        ]);

        // New instance of Club model
        $club = Club::findOrFail($id);
        
        // Assign validated input values to $club
        $club->name = $request->input('name');
        $club->stadium = $request->input('stadium');

        // Try to update club
        if($club->update()) {
            return response()->json(new ClubResource($club), 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get single club with id from route $id
        $club = Club::findOrFail($id);

        // Try to delete club
        if($club->delete()) {
            return response()->json([],204); // Respond with status code 204
        }
    }
}
