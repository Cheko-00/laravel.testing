@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="bg-white border-bottom mb-4">
        <div class="container py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 fw-bold mb-0">Users</h1>
                    <small class="text-muted">{{ $users->total() }} users registered</small>
                </div>
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    New User
                </a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @include('partials.alerts')

        {{-- Toolbar --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted">
                Showing <strong>{{ $users->firstItem() }}–{{ $users->lastItem() }}</strong>
                of <strong>{{ $users->total() }}</strong>
            </small>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="btnList" onclick="setView('list')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    List
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnGrid" onclick="setView('grid')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h6v6H4zm10 0h6v6h-6zM4 14h6v6H4zm10 0h6v6h-6z"/>
                    </svg>
                    Cards
                </button>
            </div>
        </div>

        {{-- ── LIST VIEW ── --}}
        <div id="viewList">
            <div class="card border shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="text-uppercase text-muted fw-semibold small ps-4">Name</th>
                            <th class="text-uppercase text-muted fw-semibold small">Description</th>
                            <th class="text-uppercase text-muted fw-semibold small">Team</th>
                            <th class="text-uppercase text-muted fw-semibold small text-end pe-4">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center fw-bold"
                                             style="width:36px; height:36px; font-size:.8rem; flex-shrink:0;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-muted small">{{$user->email}}</td>
                                <td class="text-muted small">
                                    @if($user->teams->count() > 0)
                                        @foreach($user->teams as $team)
                                            <span class="badge bg-secondary me-1">{{ $team->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No teams</span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-team-name="{{ $user->name }}"
                                                data-action="{{ route('users.destroy', $user) }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">No users found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── GRID VIEW ── --}}
        <div id="viewGrid" class="d-none">
            @forelse($users as $user)
                @if($loop->first)
                    <div class="row g-3">
                        @endif

                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-body d-flex flex-column gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                             style="width:44px; height:44px; font-size:1rem;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="fw-bold mb-0">{{ $user->name }}</p>
                                            @if($user->teams->count() > 0)
                                                @foreach($user->teams as $team)
                                                    <span class="badge bg-secondary me-1">{{ $team->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No teams</span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-muted small flex-grow-1 mb-0">{{ $user->email }}</p>
                                </div>
                                <div class="card-footer bg-transparent d-flex gap-2 justify-content-end">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-team-name="{{ $user->name }}"
                                            data-action="{{ route('users.destroy', $user) }}">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($loop->last)
                    </div>
                @endif
            @empty
                <p class="text-center text-muted py-5">No teams found.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    {{-- ── DELETE MODAL ── --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center py-4 px-4">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:56px; height:56px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 01-1-1V5a1 1 0 011-1h6a1 1 0 011 1v1a1 1 0 01-1 1H9z"/>
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1">Delete user</h5>
                    <p class="text-muted small mb-1">
                        You are about to delete <strong id="modalTeamName"></strong>.
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
        function setView(mode) {
            const isList = mode === 'list';
            document.getElementById('viewList').classList.toggle('d-none', !isList);
            document.getElementById('viewGrid').classList.toggle('d-none', isList);
            document.getElementById('btnList').classList.toggle('active', isList);
            document.getElementById('btnGrid').classList.toggle('active', !isList);
            localStorage.setItem('teamsView', mode);
        }

        const saved = localStorage.getItem('teamsView');
        if (saved === 'grid') setView('grid');

        document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            document.getElementById('modalTeamName').textContent = btn.dataset.teamName;
            document.getElementById('deleteForm').setAttribute('action', btn.dataset.action);
        });
    </script>
@endpush
