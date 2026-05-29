@extends('layouts.app')

@section('content')
    <div class="bg-white border-bottom mb-4">
        <div class="container py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 fw-bold mb-0">Tickets</h1>
                    <small class="text-muted">
                        @if($tickets->total() > 0)
                            {{ $tickets->total() }} tickets registered
                        @else
                            No tickets registered
                        @endif
                    </small>
                </div>
                <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Ticket
                </a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @include('partials.alerts')

        {{-- Toolbar --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted">
                @if($tickets->total() > 0)
                    Showing <strong>{{ $tickets->firstItem() }}–{{ $tickets->lastItem() }}</strong>
                    of <strong>{{ $tickets->total() }}</strong>
                @else
                    No tickets found
                @endif
            </small>
            <div class="btn-group btn-group-sm" role="group" aria-label="View toggle">
                <button type="button" class="btn btn-outline-secondary active" id="btnList" onclick="setView('list')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    List
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnGrid" onclick="setView('grid')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4h6v6H4zm10 0h6v6h-6zM4 14h6v6H4zm10 0h6v6h-6z"/>
                    </svg>
                    Card
                </button>
            </div>
        </div>

        {{-- ── VISTA DE LISTA ── --}}
        <div id="viewList">
            <div class="card border shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-uppercase text-muted fw-semibold small ps-4">#</th>
                                <th class="text-uppercase text-muted fw-semibold small">Title</th>
                                <th class="text-uppercase text-muted fw-semibold small">Category</th>
                                <th class="text-uppercase text-muted fw-semibold small">Priority</th>
                                <th class="text-uppercase text-muted fw-semibold small">Status</th>
                                <th class="text-uppercase text-muted fw-semibold small">Due date</th>
                                <th class="text-uppercase text-muted fw-semibold small text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    {{-- Número --}}
                                    <td class="ps-4">
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                           class="text-decoration-none font-monospace small text-muted">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                    </td>

                                    {{-- Título --}}
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                           class="text-decoration-none text-dark fw-semibold">
                                            {{ $ticket->title }}
                                        </a>
                                        @if($ticket->team)
                                            <br>
                                            <small class="text-muted">{{ $ticket->team->name }}</small>
                                        @endif
                                    </td>

                                    {{-- Categoría --}}
                                    <td class="small">
                                        @if($ticket->category)
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="rounded-circle" style="width:8px; height:8px; flex-shrink:0;
                                                    background-color: {{ $ticket->category->color }};"></span>
                                                {{ $ticket->category->name }}
                                            </div>
                                            @if($ticket->subcategory)
                                                <small class="text-muted ms-2">↳ {{ $ticket->subcategory->name }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted fst-italic">—</span>
                                        @endif
                                    </td>

                                    {{-- Prioridad --}}
                                    <td>
                                        <span class="badge {{ $ticket->priority_level->badgeClass() }}">
                                            {{ $ticket->priority_level->label() }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        <span class="badge {{ $ticket->status->badgeClass() }}">
                                            {{ $ticket->status->label() }}
                                        </span>
                                    </td>

                                    {{-- Due date --}}
                                    <td class="small">
                                        @if($ticket->due_at)
                                            @php
                                                $overdue = $ticket->due_at->isPast()
                                                    && !in_array($ticket->status->value, ['resolved', 'closed']);
                                            @endphp
                                            <span class="{{ $overdue ? 'text-danger fw-semibold' : 'text-muted' }}">
                                                @if($overdue)<i class="bi bi-exclamation-circle me-1"></i>@endif
                                                {{ $ticket->due_at->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted fst-italic">—</span>
                                        @endif
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="text-end pe-4">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('tickets.show', $ticket) }}"
                                               class="btn btn-outline-secondary btn-sm">View</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-ticket-number="{{ $ticket->ticket_number }}"
                                                    data-action="{{ route('tickets.destroy', $ticket) }}">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        There are no registered tickets.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── VISTA DE TARJETAS (GRID) ── --}}
        <div id="viewGrid" class="d-none">
            @forelse($tickets as $ticket)
                @if($loop->first)
                    <div class="row g-3">
                @endif

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 border shadow-sm">
                        <div class="card-body d-flex flex-column gap-2">

                            {{-- Header: número + título --}}
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                     style="width:44px; height:44px; font-size:.8rem;
                                            background-color: {{ $ticket->priority_level->color() }}20;
                                            color: {{ $ticket->priority_level->color() }};">
                                    {{ strtoupper(substr($ticket->priority_level->label(), 0, 2)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <p class="fw-bold mb-0 text-truncate">
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                           class="text-decoration-none text-dark stretched-link">
                                            {{ $ticket->title }}
                                        </a>
                                    </p>
                                    <small class="text-muted font-monospace">{{ $ticket->ticket_number }}</small>
                                </div>
                            </div>

                            {{-- Categoría --}}
                            @if($ticket->category)
                                <div class="d-flex align-items-center gap-1">
                                    <span class="rounded-circle" style="width:8px; height:8px; flex-shrink:0;
                                        background-color: {{ $ticket->category->color }};"></span>
                                    <small class="text-muted">{{ $ticket->category->name }}
                                        @if($ticket->subcategory) · {{ $ticket->subcategory->name }}@endif
                                    </small>
                                </div>
                            @endif

                            {{-- Badges --}}
                            <div class="d-flex align-items-center gap-2 flex-wrap mt-auto">
                                <span class="badge {{ $ticket->status->badgeClass() }}">
                                    {{ $ticket->status->label() }}
                                </span>
                                <span class="badge {{ $ticket->priority_level->badgeClass() }}">
                                    {{ $ticket->priority_level->label() }}
                                </span>
                                @if($ticket->due_at)
                                    @php
                                        $overdue = $ticket->due_at->isPast()
                                            && !in_array($ticket->status->value, ['resolved', 'closed']);
                                    @endphp
                                    <small class="ms-auto {{ $overdue ? 'text-danger fw-semibold' : 'text-muted' }}">
                                        @if($overdue)<i class="bi bi-exclamation-circle"></i>@endif
                                        {{ $ticket->due_at->format('M d') }}
                                    </small>
                                @endif
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="card-footer bg-transparent d-flex gap-2 justify-content-end">
                            {{-- stretched-link cubre la card, el botón delete necesita z-index mayor --}}
                            <button type="button" class="btn btn-outline-danger btn-sm"
                                    style="position:relative; z-index:2;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-ticket-number="{{ $ticket->ticket_number }}"
                                    data-action="{{ route('tickets.destroy', $ticket) }}">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                @if($loop->last)
                    </div>
                @endif
            @empty
                <p class="text-center text-muted py-5">There are no registered tickets.</p>
            @endforelse
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $tickets->links() }}
        </div>
    </div>

    {{-- ── MODAL DE ELIMINACIÓN ── --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-4 px-4">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex
                                align-items-center justify-content-center mb-3"
                         style="width:56px; height:56px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 01-1-1V5a1 1 0 011-1h6a1 1 0 011 1v1a1 1 0 01-1 1H9z"/>
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1">Delete ticket</h5>
                    <p class="text-muted small mb-1">
                        You are about to delete <strong id="modalTicketNumber"></strong>.
                    </p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Yes, delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            window.setView = function (mode) {
                const isList = mode === 'list';
                document.getElementById('viewList').classList.toggle('d-none', !isList);
                document.getElementById('viewGrid').classList.toggle('d-none', isList);
                document.getElementById('btnList').classList.toggle('active', isList);
                document.getElementById('btnGrid').classList.toggle('active', !isList);
                localStorage.setItem('ticketsView', mode);
            };

            const savedView = localStorage.getItem('ticketsView');
            if (savedView === 'grid') setView('grid');

            document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
                const btn = e.relatedTarget;
                document.getElementById('modalTicketNumber').textContent = btn.dataset.ticketNumber;
                document.getElementById('deleteForm').setAttribute('action', btn.dataset.action);
            });

        });
    </script>
@endpush
