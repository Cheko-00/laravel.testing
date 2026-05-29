@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <a href="{{ route('tickets.index') }}" class="text-muted text-decoration-none small">
                        ← Tickets
                    </a>
                </div>
                <h1 class="h4 fw-bold mb-0">{{ $ticket->title }}</h1>
                <small class="text-muted font-monospace">{{ $ticket->ticket_number }}</small>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteModal">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </div>
        </div>

        @include('partials.alerts')

        <div class="row g-4">

            {{-- Columna principal --}}
            <div class="col-md-8">

                {{-- Descripción --}}
                <div class="card border shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-file-text text-muted"></i>
                        <h6 class="mb-0 fw-semibold">Description</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $ticket->description }}</p>
                    </div>
                </div>

                {{-- Actividad / Timeline (placeholder para futuro) --}}
                <div class="card border shadow-sm">
                    <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-muted"></i>
                        <h6 class="mb-0 fw-semibold">Activity</h6>
                    </div>
                    <div class="card-body">

                        {{-- Evento: creación del ticket --}}
                        <div class="d-flex gap-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle
                                                d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                    style="width:34px; height:34px; font-size:.75rem;">
                                    {{ strtoupper(substr($ticket->createdBy->name ?? 'S', 0, 2)) }}
                                </div>
                            </div>
                            <div class="pb-3">
                                <p class="mb-0 small">
                                    <strong>{{ $ticket->createdBy->name ?? 'System' }}</strong>
                                    created this ticket
                                </p>
                                <small class="text-muted">
                                    {{ $ticket->created_at->diffForHumans() }}
                                    · {{ $ticket->created_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>

                        @if($ticket->resolved_at)
                            <div class="d-flex gap-3">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle
                                                        d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:34px; height:34px;">
                                        <i class="bi bi-check-lg" style="font-size:.85rem;"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0 small"><strong>Ticket resolved</strong></p>
                                    <small class="text-muted">
                                        {{ $ticket->resolved_at->diffForHumans() }}
                                        · {{ $ticket->resolved_at->format('M d, Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-md-4">
                <div class="card border shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-semibold">Details</h6>
                    </div>
                    <div class="card-body d-flex flex-column gap-3">

                        {{-- Status --}}
                        <div>
                            <small class="text-uppercase text-muted fw-semibold"
                                style="font-size:.7rem; letter-spacing:.05em;">
                                Status
                            </small>
                            <div class="mt-1">
                                <span class="badge {{ $ticket->status->badgeClass() }}">
                                    {{ $ticket->status->label() }}
                                </span>
                            </div>
                        </div>

                        {{-- Priority --}}
                        <div>
                            <small class="text-uppercase text-muted fw-semibold"
                                style="font-size:.7rem; letter-spacing:.05em;">
                                Priority
                            </small>
                            <div class="mt-1 d-flex align-items-center gap-2">
                                <span class="rounded-circle" style="width:10px; height:10px; flex-shrink:0;
                                        background-color: {{ $ticket->priority_level->color() }};"></span>
                                <span class="small fw-semibold">{{ $ticket->priority_level->label() }}</span>
                                <span class="text-muted small">(SLA {{ $ticket->priority_level->slaHours() }}h)</span>
                            </div>
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <small class="text-uppercase text-muted fw-semibold"
                                style="font-size:.7rem; letter-spacing:.05em;">
                                Category
                            </small>
                            <div class="mt-1 d-flex align-items-center gap-2">
                                @if($ticket->category)
                                                @php
                                                    // Si la categoría guardada tiene padre, el padre es la categoría raíz
                                                    $rootCategory = $ticket->category->parent ?? $ticket->category;
                                                @endphp
                                                <span class="rounded-circle" style="width:10px; height:10px; flex-shrink:0;
                                    background-color: {{ $rootCategory->color }};"></span>
                                                <span class="small">{{ $rootCategory->name }}</span>
                                @else
                                    <span class="text-muted small fst-italic">Uncategorized</span>
                                @endif
                            </div>
                        </div>

                        {{-- Subcategoría — solo si la categoría guardada ES una hija --}}
                        @if($ticket->category && $ticket->category->parent_id)
                                <div>
                                    <small class="text-uppercase text-muted fw-semibold"
                                        style="font-size:.7rem; letter-spacing:.05em;">
                                        Subcategory
                                    </small>
                                    <div class="mt-1 d-flex align-items-center gap-2">
                                        <span class="rounded-circle" style="width:10px; height:10px; flex-shrink:0;
                            background-color: {{ $ticket->category->color ?? $ticket->category->parent->color }};"></span>
                                        <span class="small">{{ $ticket->category->name }}</span>
                                    </div>
                                </div>
                        @endif

                        <hr class="my-0">

                        {{-- Asignado a --}}
                        <div>
                            <small class="text-uppercase text-muted fw-semibold"
                                style="font-size:.7rem; letter-spacing:.05em;">
                                Assigned to
                            </small>
                            <div class="mt-1">
                                @if($ticket->assignedTo)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle
                                                            d-flex align-items-center justify-content-center fw-bold"
                                            style="width:28px; height:28px; font-size:.7rem; flex-shrink:0;">
                                            {{ strtoupper(substr($ticket->assignedTo->name, 0, 2)) }}
                                        </div>
                                        <span class="small">{{ $ticket->assignedTo->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small fst-italic">Unassigned</span>
                                @endif
                            </div>
                        </div>

                        {{-- Equipo --}}
                        <div>
                            <small class="text-uppercase text-muted fw-semibold"
                                style="font-size:.7rem; letter-spacing:.05em;">
                                Team
                            </small>
                            <div class="mt-1">
                                @if($ticket->team)
                                    <span class="small">{{ $ticket->team->name }}</span>
                                @else
                                    <span class="text-muted small fst-italic">No team assigned</span>
                                @endif
                            </div>
                        </div>

                        <hr class="my-0">

                        {{-- Fechas --}}
                        <div>
                            <small class="text-uppercase text-muted fw-semibold"
                                style="font-size:.7rem; letter-spacing:.05em;">
                                Due date
                            </small>
                            <div class="mt-1">
                                @if($ticket->due_at)
                                    @php
                                        $isOverdue = $ticket->due_at->isPast() && !in_array($ticket->status->value, ['resolved', 'closed']);
                                    @endphp
                                    <span class="small {{ $isOverdue ? 'text-danger fw-semibold' : '' }}">
                                        @if($isOverdue)
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                        @endif
                                        {{ $ticket->due_at->format('M d, Y H:i') }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $ticket->due_at->diffForHumans() }}</small>
                                @else
                                    <span class="text-muted small fst-italic">No due date</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <small class="text-uppercase text-muted fw-semibold"
                                style="font-size:.7rem; letter-spacing:.05em;">
                                Created
                            </small>
                            <div class="mt-1">
                                <span class="small">{{ $ticket->created_at->format('M d, Y H:i') }}</span>
                                <br>
                                <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        @if($ticket->resolved_at)
                            <div>
                                <small class="text-uppercase text-muted fw-semibold"
                                    style="font-size:.7rem; letter-spacing:.05em;">
                                    Resolved
                                </small>
                                <div class="mt-1">
                                    <span class="small text-success">{{ $ticket->resolved_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal eliminación --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-4 px-4">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex
                                    align-items-center justify-content-center mb-3" style="width:56px; height:56px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 01-1-1V5a1 1 0 011-1h6a1 1 0 011 1v1a1 1 0 01-1 1H9z" />
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1">Delete ticket</h5>
                    <p class="text-muted small mb-1">
                        You are about to delete <strong>{{ $ticket->ticket_number }}</strong>.
                    </p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Yes, delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
