@extends('layouts.app')
@section('content')
    <div class="container" style="max-width:500px">
        <h2>Edit Team</h2>
        {{--@include('partials.alerts')--}}
        <form action="{{ route('teams.update', $team) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Team name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $team->name) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control"
                       value="{{ old('name', $team->description) }}">
            </div>

            <div class="form-check form-switch mb-3">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="checkIsActive" {{ old('is_active', $team->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="checkIsActive">
                    Active
                </label>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('teams.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
