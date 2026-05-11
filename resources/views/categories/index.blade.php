@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="bg-white border-bottom mb-4">
        <div class="container py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 fw-bold mb-0">Categories</h1>
                    {{-- FIX: texto mixto "categorías registered" → inglés consistente --}}
                    <small class="text-muted">{{ $categories->total() }} categories registered</small>
                </div>
                <a href="{{ route('categories.create') }}"
                   class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Category
                </a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @include('partials.alerts')

        {{-- Toolbar --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted">
                {{-- FIX: cuando no hay resultados firstItem()/lastItem() retornan null → evitar "–" vacío --}}
                @if($categories->total() > 0)
                    Showing <strong>{{ $categories->firstItem() }}–{{ $categories->lastItem() }}</strong>
                    of <strong>{{ $categories->total() }}</strong>
                @else
                    No categories found
                @endif
            </small>
            <div class="btn-group btn-group-sm" role="group" aria-label="View toggle">
                <button type="button" class="btn btn-outline-secondary active" id="btnList"
                        onclick="setView('list')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    List
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnGrid"
                        onclick="setView('grid')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            <th class="text-uppercase text-muted fw-semibold small ps-4">Name</th>
                            <th class="text-uppercase text-muted fw-semibold small">Slug</th>
                            <th class="text-uppercase text-muted fw-semibold small">Color</th>
                            <th class="text-uppercase text-muted fw-semibold small">Status</th>
                            <th class="text-uppercase text-muted fw-semibold small text-end pe-4">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            {{-- Fila categoría padre --}}
                            <tr class="category-row"
                                style="cursor: {{ $category->subcategories->count() ? 'pointer' : 'default' }};"
                                @if($category->subcategories->count())
                                    data-collapse-target="sub-{{ $category->id }}"
                                aria-expanded="false"
                                @endif>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        {{-- Chevron: solo si tiene subcategorías --}}
                                        @if($category->subcategories->count())
                                            <svg class="chevron-icon text-muted"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 width="14" height="14" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="2.5"
                                                 style="transition: transform .2s; flex-shrink:0;">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 5l7 7-7 7"/>
                                            </svg>
                                        @else
                                            <span style="width:14px; flex-shrink:0;"></span>
                                        @endif

                                        <div class="bg-primary bg-opacity-10 text-primary rounded-2
                                                        d-flex align-items-center justify-content-center fw-bold"
                                             style="width:36px; height:36px; font-size:.8rem; flex-shrink:0;">
                                            {{ strtoupper(substr($category->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold">{{ $category->name }}</span>
                                            @if($category->subcategories->count())
                                                <span class="badge bg-primary bg-opacity-10 text-primary ms-1"
                                                      style="font-size:.7rem;">
                                                        {{ $category->subcategories->count() }}
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted small"><code>{{ $category->slug }}</code></td>
                                <td class="text-muted small">
                                    <div class="d-flex align-items-center gap-2">
                                            <span class="rounded-circle"
                                                  style="width:16px; height:16px; background-color: {{ $category->color }};"></span>
                                        {{ $category->color }}
                                    </div>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="btn btn-outline-secondary btn-sm">Edit</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-category-name="{{ $category->name }}"
                                                data-action="{{ route('categories.destroy', $category) }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Filas subcategorías (colapsables) --}}
                            {{-- FIX: el <tr> collapse debe tener la clase "collapse" correctamente --}}
                            <tr>
                                <td colspan="5" class="p-0 border-0">
                                    <div id="sub-{{ $category->id }}" class="collapse">
                                        <table class="table table-sm align-middle mb-0">
                                            <tbody class="bg-light">
                                            @foreach($category->subcategories as $sub)
                                                <tr>
                                                    <td class="ps-5" style="width:35%">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 width="12" height="12" fill="none"
                                                                 viewBox="0 0 24 24" stroke="currentColor"
                                                                 stroke-width="2" class="text-muted"
                                                                 style="flex-shrink:0;">
                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      d="M9 5l7 7-7 7"/>
                                                            </svg>
                                                            <span class="text-muted small fw-semibold">
                                                                        {{ $sub->name }}
                                                                    </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted small">
                                                        <code>{{ $sub->slug }}</code>
                                                    </td>
                                                    <td class="text-muted small">
                                                        <div class="d-flex align-items-center gap-2">
                                                                    <span class="rounded-circle"
                                                                          style="width:12px; height:12px; background-color: {{ $sub->color }};"></span>
                                                            {{ $sub->color }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($sub->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <a href="{{ route('categories.edit', $sub) }}"
                                                               class="btn btn-outline-secondary btn-sm">Edit</a>
                                                            <button type="button"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteModal"
                                                                    data-category-name="{{ $sub->name }}"
                                                                    data-action="{{ route('categories.destroy', $sub) }}">
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            {{-- Botón agregar subcategoría --}}
                                            <tr>
                                                <td colspan="5" class="ps-5 py-2">
                                                    <a href="{{ route('categories.create', ['parent' => $category->id]) }}"
                                                       class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                             height="12" fill="none" viewBox="0 0 24 24"
                                                             stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                        Add subcategory
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    There are no registered categories.
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
            @forelse($categories as $category)
                @if($loop->first)
                    <div class="row g-3">
                        @endif

                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="card h-100 border shadow-sm">
                                <div class="card-body d-flex flex-column gap-2">

                                    {{-- Header categoría --}}
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                             style="width:44px; height:44px; font-size:1rem;
                                            background-color: {{ $category->color }}20;
                                            color: {{ $category->color }};">
                                            {{ strtoupper(substr($category->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="fw-bold mb-0">{{ $category->name }}</p>
                                            <small class="text-muted">{{ $category->slug }}</small>
                                        </div>
                                    </div>

                                    {{-- Color + Status --}}
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <div class="rounded-circle"
                                             style="width:14px; height:14px; background-color: {{ $category->color }};"></div>
                                        <small class="text-muted">{{ $category->color }}</small>
                                        @if($category->is_active)
                                            <span class="badge bg-success ms-auto">Active</span>
                                        @else
                                            <span class="badge bg-secondary ms-auto">Inactive</span>
                                        @endif
                                    </div>

                                    {{-- Subcategorías como pills --}}
                                    @if($category->subcategories->count())
                                        <hr class="my-1">
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($category->subcategories as $sub)
                                                {{-- Cada pill lleva al edit de la subcategoría --}}
                                                <a href="{{ route('categories.edit', $sub) }}"
                                                   class="badge rounded-pill border d-inline-flex align-items-center gap-1 text-decoration-none"
                                                   style="background-color: {{ $sub->color }}18;
                                                  color: {{ $sub->color }};
                                                  border-color: {{ $sub->color }}50 !important;
                                                  font-size: .72rem;">
                                            <span class="rounded-circle"
                                                  style="width:6px; height:6px; background-color: {{ $sub->color }}; flex-shrink:0;"></span>
                                                    {{ $sub->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted small mb-0 fst-italic">No subcategories yet.</p>
                                    @endif

                                </div>

                                <div class="card-footer bg-transparent d-flex gap-2 justify-content-between align-items-center">
                                    <a href="{{ route('categories.create', ['parent' => $category->id]) }}"
                                       class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Add sub
                                    </a>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="btn btn-outline-secondary btn-sm">Edit</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-category-name="{{ $category->name }}"
                                                data-action="{{ route('categories.destroy', $category) }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($loop->last)
                    </div>
                @endif
            @empty
                <p class="text-center text-muted py-5">There are no registered categories.</p>
            @endforelse
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $categories->links() }}
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
                    {{-- FIX: título singular --}}
                    <h5 class="fw-bold mb-1">Delete category</h5>
                    <p class="text-muted small mb-1">
                        You are about to delete <strong id="modalCategoryName"></strong>.
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

            // ── Accordion manual ─────────────────────────────────────────
            document.querySelectorAll('tr[data-collapse-target]').forEach(row => {
                row.addEventListener('click', function (e) {
                    if (e.target.closest('a, button, form')) return;

                    const collapseEl = document.getElementById(this.dataset.collapseTarget);
                    if (!collapseEl) return;

                    const isOpen = collapseEl.classList.contains('show');

                    if (isOpen) {
                        collapseEl.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                        this.querySelector('.chevron-icon')?.style.setProperty('transform', 'rotate(0deg)');
                    } else {
                        collapseEl.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                        this.querySelector('.chevron-icon')?.style.setProperty('transform', 'rotate(90deg)');
                    }
                });
            });

            // ── Vista list/grid ──────────────────────────────────────────
            function setView(mode) {
                const isList = mode === 'list';
                document.getElementById('viewList').classList.toggle('d-none', !isList);
                document.getElementById('viewGrid').classList.toggle('d-none', isList);
                document.getElementById('btnList').classList.toggle('active', isList);
                document.getElementById('btnGrid').classList.toggle('active', !isList);
                localStorage.setItem('categoriesView', mode);
            }
            window.setView = setView; // exponer para los onclick del HTML

            const savedView = localStorage.getItem('categoriesView');
            if (savedView === 'grid') setView('grid');

            // ── Modal de eliminación ─────────────────────────────────────
            document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
                const btn = e.relatedTarget;
                document.getElementById('modalCategoryName').textContent = btn.dataset.categoryName;
                document.getElementById('deleteForm').setAttribute('action', btn.dataset.action);
            });

        });
    </script>
@endpush
