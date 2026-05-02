@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ $team->name }}</h2>
            <div>
                <a href="{{ route('teams.members.create', $team) }}" class="btn btn-primary btn-sm">
                    + Add Member
                </a>
                <a href="{{ route('teams.edit', $team) }}" class="btn btn-outline-secondary btn-sm">
                    Edit Team
                </a>
                <a href="{{ route('teams.index') }}" class="btn btn-outline-secondary btn-sm">
                    Back to Teams
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card border shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Team Information</h5>
                        <p class="text-muted">{{ $team->description ?: 'No description provided.' }}</p>
                        <p>Status:
                            @if($team->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </p>
                        <p>Members: {{ $team->users()->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Team Members</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($team->users as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>
                                        <form action="{{ route('teams.members.update-role', [$team, $member]) }}"
                                              method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <select name="role" class="form-select form-select-sm"
                                                    style="width: auto; display: inline-block;"
                                                    onchange="this.form.submit()">
                                                <option value="member" {{ $member->pivot->role == 'member' ? 'selected' : '' }}>
                                                    Member
                                                </option>
                                                <option value="leader" {{ $member->pivot->role == 'leader' ? 'selected' : '' }}>
                                                    Leader
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('teams.members.destroy', [$team, $member]) }}"
                                              method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Remove {{ $member->name }} from team?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No members in this team yet.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
