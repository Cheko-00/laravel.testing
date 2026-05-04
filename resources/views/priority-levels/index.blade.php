@extends('layouts.app')

@section('content')

    <div class="bg-white border-bottom mb-4">
        <div class="container py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 fw-bold mb-0">Priority Levels</h1>
                    <small class="text-muted">These levels are fixed by the system</small>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($levels as $level)
                <div class="col-md-3 mb-3">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <div class="rounded-circle mx-auto mb-3" style="width: 50px; height: 50px; background-color: {{ $level->color() }};"></div>
                            <h5 class="fw-bold">{{ $level->label() }}</h5>
                            <p class="small text-muted">SLA: {{ $level->slaHours() }} hours</p>
                            <code>{{ $level->value }}</code>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
