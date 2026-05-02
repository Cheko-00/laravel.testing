@extends('layouts.app')
@section('content')
    <div class="container" style="max-width:600px">
        <h2>New team</h2>
        {{--@include('partials.alerts')--}}
        <form action="{{ route('teams.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Team name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
            </div>
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="checkIsActive" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="checkIsActive">
                    Active
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('teams.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
