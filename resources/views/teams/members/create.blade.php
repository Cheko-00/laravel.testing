@extends('layouts.app')

@section('content')
    <div class="container" style="max-width:600px">
        <div class="card border shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Add Member to {{ $team->name }}</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('teams.members.store', $team) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Select User</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Choose a user...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                            <option value="leader" {{ old('role') == 'leader' ? 'selected' : '' }}>Leader</option>
                        </select>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Add Member</button>
                        <a href="{{ route('teams.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
