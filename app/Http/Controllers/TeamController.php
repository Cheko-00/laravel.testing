<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::withCount('users')->latest()->paginate(6);
        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        // dd($request->validated()); // Temporal: ver qué datos llegan
        Team::create($request->validated());
        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Team $team){
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team->update($request->validated());
        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        if ($team->users()->exists()) {
            return redirect()->route('teams.index')
            ->with('error', "Cannot delete team '{$team->name}'  Please reassign them first.");
        }

        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team removed correctly.');
    }
}
