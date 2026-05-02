<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function create(Team $team)
    {
        $existingUserIds = $team->users()->pluck('user_id')->toArray();

        $users = User::whereNotIn('id', $existingUserIds)
            ->orderBy('name')
            ->get();

        return view('teams.members.create', compact('team', 'users'));
    }

    public function store(Request $request, Team $team)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:member,leader',
        ]);

        if ($team->users()->where('user_id', $validated['user_id'])->exists()) {
            return back()->with('error', 'User is already a member of this team.');
        }

        $team->users()->attach($validated['user_id'], [
            'role' => $validated['role']
        ]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'User added to team successfully.');
    }
    public function destroy(Team $team, User $user)
    {
        $team->users()->detach($user->id);

        return redirect()->route('teams.show', $team)
            ->with('success', 'User removed from team successfully.');
    }

    public function updateRole(Request $request, Team $team, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:member,leader',
        ]);

        $team->users()->updateExistingPivot($user->id, [
            'role' => $validated['role']
        ]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'User role updated successfully.');
    }
}
