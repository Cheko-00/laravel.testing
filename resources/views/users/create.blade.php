@extends('layouts.app')
@section('content')
    <div class="container" style="max-width:600px">
        <h2>New user</h2>
        @include('partials.alerts')
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <select name="team_id" class="form-select" aria-label="Default select example">
                    <option selected>Open to select a team</option>
                    @foreach($teams as $team)
                        <option value="{{$team->id}}">{{$team->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="password-confirm" class="col-form-label text-md-end">{{ __('Password') }}</label>

                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">

                </div>
                <div class="mb-3 col-md-6">
                    <label for="password-confirm"
                           class=" col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
