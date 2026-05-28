@extends('layouts.app')

@section('content')
<div class="container px-3 px-md-4 py-4">

    {{-- Alertas de sesión --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="ti ti-circle-check" style="font-size:18px"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="ti ti-alert-circle" style="font-size:18px"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h4 fw-semibold mb-0">{{ __('Categories') }}</h1>
            <p class="text-muted small mb-0">{{ __('Manage categories and subcategories') }}</p>
        </div>
        <button class="btn btn-primary btn-sm d-flex align-items-center gap-2"
                data-bs-toggle="collapse"
                data-bs-target="#formNueva"
                aria-expanded="false"
                aria-controls="formNueva">
            <i class="ti ti-plus" style="font-size:16px"></i>
            {{ __('New category') }}
        </button>
    </div>

    {{-- Métricas --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border h-100">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">{{ __('Total') }}</p>
                    <p class="h5 fw-semibold mb-0">{{ $totalCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border h-100">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">{{ __('Active') }}</p>
                    <p class="h5 fw-semibold mb-0 text-success">{{ $activeCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border h-100">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">{{ __('Inactive') }}</p>
                    <p class="h5 fw-semibold mb-0 text-danger">{{ $inactiveCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border h-100">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">{{ __('Root') }}</p>
                    <p class="h5 fw-semibold mb-0">{{ $rootCount }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulario nueva categoría (colapsable) --}}
    <div class="collapse mb-4 @error('name') show @enderror @error('slug') show @enderror" id="formNueva">
        <div class="card border">
            <div class="card-header bg-white border-bottom py-3">
                <h2 class="h6 fw-semibold mb-0 d-flex align-items-center gap-2">
                    <i class="ti ti-circle-plus text-primary" style="font-size:18px" aria-hidden="true"></i>
                    {{ __('New category') }}
                </h2>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label small fw-medium">
                                {{ __('Name') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="ej. Tecnología"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="slug" class="form-label small fw-medium">
                                {{ __('Slug') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text text-muted">/</span>
                                <input type="text"
                                       id="slug"
                                       name="slug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug') }}"
                                       placeholder="tecnologia"
                                       required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">{{ __('Auto-generated from name.') }}</div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="color" class="form-label small fw-medium">{{ __('Color') }}</label>
                            <div class="input-group input-group-sm">
                                <input type="color"
                                       id="color"
                                       class="form-control form-control-color form-control-sm"
                                       value="{{ old('color', '#6366f1') }}"
                                       style="max-width:48px">
                                <input type="text"
                                       id="colorHex"
                                       name="color"
                                       class="form-control"
                                       value="{{ old('color', '#6366f1') }}"
                                       placeholder="#6366f1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="parent_id" class="form-label small fw-medium">{{ __('Parent category') }}</label>
                            <select id="parent_id" name="parent_id" class="form-select form-select-sm">
                                <option value="">{{ __('None (root)') }}</option>
                                @foreach ($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-medium">{{ __('Status') }}</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_active"
                                       id="isActive"
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="isActive">{{ __('Active') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top d-flex justify-content-end gap-2 py-3">
                    <button type="button"
                            class="btn btn-sm btn-outline-secondary"
                            data-bs-toggle="collapse"
                            data-bs-target="#formNueva">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2">
                        <i class="ti ti-device-floppy" style="font-size:15px"></i>
                        {{ __('Save category') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border">

        {{-- Filtros --}}
        <div class="card-body border-bottom py-3">
            <form method="GET" action="{{ route('categories.index') }}" class="row g-2 align-items-center">
                <div class="col-12 col-sm-5 col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="ti ti-search text-muted" style="font-size:15px"></i>
                        </span>
                        <input type="text"
                               name="search"
                               class="form-control border-start-0 ps-0"
                               placeholder="{{ __('Search by name or slug…') }}"
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">{{ __('Status') }}</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>
                <div class="col-6 col-sm-4 col-md-3">
                    <select name="type" class="form-select form-select-sm">
                        <option value="">{{ __('All categories') }}</option>
                        <option value="root" {{ request('type') === 'root' ? 'selected' : '' }}>{{ __('Root only') }}</option>
                        <option value="sub" {{ request('type') === 'sub' ? 'selected' : '' }}>{{ __('Subcategories only') }}</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 d-flex justify-content-md-end gap-2">
                    <button type="submit" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-adjustments-horizontal" style="font-size:15px"></i>
                        <span class="d-none d-sm-inline">{{ __('Filter') }}</span>
                    </button>
                    @if (request()->hasAny(['search', 'status', 'type']))
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                            <i class="ti ti-x" style="font-size:15px"></i>
                            <span class="d-none d-sm-inline">{{ __('Clear') }}</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabla responsive --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="min-width:580px">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width:40px">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>{{ __('Name') }}</th>
                        <th class="d-none d-md-table-cell">{{ __('Slug') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('Color') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="d-none d-lg-table-cell">{{ __('Parent') }}</th>
                        <th class="d-none d-md-table-cell text-muted" style="font-size:13px">{{ __('Created') }}</th>
                        <th style="width:90px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="ps-3">
                                <input type="checkbox" class="form-check-input" value="{{ $category->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($category->color)
                                        <span class="rounded-circle d-inline-block flex-shrink-0"
                                              style="width:10px;height:10px;background:{{ $category->color }}"></span>
                                    @else
                                        <span class="rounded-circle d-inline-block flex-shrink-0 bg-secondary"
                                              style="width:10px;height:10px"></span>
                                    @endif
                                    <span class="fw-medium">{{ $category->name }}</span>
                                </div>
                                <small class="text-muted d-md-none">
                                    {{ $category->slug }}
                                    @if ($category->parent)
                                        · {{ $category->parent->name }}
                                    @endif
                                </small>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <code class="text-secondary small">{{ $category->slug }}</code>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                @if ($category->color)
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded border flex-shrink-0"
                                              style="width:18px;height:18px;background:{{ $category->color }};display:inline-block"></span>
                                        <span class="small text-muted">{{ $category->color }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($category->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        {{ __('Active') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        {{ __('Inactive') }}
                                    </span>
                                @endif
                            </td>
                            <td class="d-none d-lg-table-cell">
                                @if ($category->parent)
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="ti ti-corner-down-right text-muted" style="font-size:13px"></i>
                                        <span class="small">{{ $category->parent->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell text-muted small">
                                {{ $category->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if (is_null($category->parent_id))
                                        <button class="btn btn-sm btn-outline-success p-1"
                                                title="{{ __('Add subcategory') }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSubcategoria{{ $category->id }}">
                                            <i class="ti ti-folder-plus" style="font-size:15px"></i>
                                            {{ __('Add') }}
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-secondary p-1"
                                            title="{{ __('Edit') }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditar{{ $category->id }}">
                                        <i class="ti ti-edit" style="font-size:15px"></i>
                                        {{ __('Edit') }}
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger p-1"
                                            title="{{ __('Delete') }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar{{ $category->id }}">
                                        <i class="ti ti-trash" style="font-size:15px"></i>
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Editar (uno por fila) --}}
                        <div class="modal fade" id="modalEditar{{ $category->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border">
                                    <div class="modal-header border-bottom py-3">
                                        <h5 class="modal-title h6 fw-semibold d-flex align-items-center gap-2">
                                            <i class="ti ti-edit text-primary" style="font-size:18px" aria-hidden="true"></i>
                                            {{ __('Edit category') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                                    </div>
                                    <form action="{{ route('categories.update', $category) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-12 col-md-6">
                                                    <label for="editName{{ $category->id }}" class="form-label small fw-medium">
                                                        {{ __('Name') }} <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                           id="editName{{ $category->id }}"
                                                           name="name"
                                                           class="form-control form-control-sm"
                                                           value="{{ $category->name }}"
                                                           required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="editSlug{{ $category->id }}" class="form-label small fw-medium">
                                                        {{ __('Slug') }} <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text text-muted">/</span>
                                                        <input type="text"
                                                               id="editSlug{{ $category->id }}"
                                                               name="slug"
                                                               class="form-control"
                                                               value="{{ $category->slug }}"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label for="editColor{{ $category->id }}" class="form-label small fw-medium">{{ __('Color') }}</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="color"
                                                               id="editColor{{ $category->id }}"
                                                               class="form-control form-control-color form-control-sm edit-color-picker"
                                                               value="{{ $category->color ?? '#6366f1' }}"
                                                               style="max-width:48px">
                                                        <input type="text"
                                                               name="color"
                                                               class="form-control edit-color-hex"
                                                               value="{{ $category->color ?? '#6366f1' }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label for="editParent{{ $category->id }}" class="form-label small fw-medium">{{ __('Parent category') }}</label>
                                                    <select id="editParent{{ $category->id }}" name="parent_id" class="form-select form-select-sm">
                                                        <option value="">{{ __('None (root)') }}</option>
                                                        @foreach ($parentCategories as $parent)
                                                            @if ($parent->id !== $category->id)
                                                                <option value="{{ $parent->id }}"
                                                                    {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                                                    {{ $parent->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="form-label small fw-medium">{{ __('Status') }}</label>
                                                    <div class="form-check form-switch mt-1">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               name="is_active"
                                                               id="editActive{{ $category->id }}"
                                                               value="1"
                                                               {{ $category->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="editActive{{ $category->id }}">
                                                            {{ __('Active') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top py-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-2">
                                                <i class="ti ti-device-floppy" style="font-size:15px"></i>
                                                {{ __('Save changes') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Eliminar (uno por fila) --}}
                        <div class="modal fade" id="modalEliminar{{ $category->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content border">
                                    <div class="modal-header border-bottom py-3">
                                        <h5 class="modal-title h6 fw-semibold d-flex align-items-center gap-2">
                                            <i class="ti ti-alert-triangle text-danger" style="font-size:18px" aria-hidden="true"></i>
                                            {{ __('Delete category') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                                    </div>
                                    <div class="modal-body py-4 text-center">
                                        <p class="mb-1 fw-medium">{{ __('Delete') }} "{{ $category->name }}"?</p>
                                        <p class="text-muted small mb-0">
                                            {{ __('This action cannot be undone. Related subcategories will also be deleted.') }}
                                        </p>
                                    </div>
                                    <div class="modal-footer border-top justify-content-center gap-2 py-3">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                            {{ __('Cancel') }}
                                        </button>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-2">
                                                <i class="ti ti-trash" style="font-size:15px"></i>
                                                {{ __('Yes, delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Subcategoría --}}
                        @if (is_null($category->parent_id))
                        <div class="modal fade" id="modalSubcategoria{{ $category->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border">
                                    <div class="modal-header border-bottom py-3">
                                        <h5 class="modal-title h6 fw-semibold d-flex align-items-center gap-2">
                                            <i class="ti ti-folder-plus text-success" style="font-size:18px" aria-hidden="true"></i>
                                            {{ __('Add subcategory') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                                    </div>
                                    <form action="{{ route('categories.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $category->id }}">
                                        <div class="modal-body">
                                            <div class="alert alert-light border d-flex align-items-center gap-2 py-2 mb-3">
                                                <i class="ti ti-corner-down-right text-muted" style="font-size:15px"></i>
                                                <span class="small">
                                                    {{ __('Parent') }}:
                                                    <strong>{{ $category->name }}</strong>
                                                </span>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-12 col-md-6">
                                                    <label for="subName{{ $category->id }}" class="form-label small fw-medium">
                                                        {{ __('Name') }} <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                           id="subName{{ $category->id }}"
                                                           name="name"
                                                           class="form-control form-control-sm sub-name-input"
                                                           placeholder="ej. Hardware"
                                                           required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="subSlug{{ $category->id }}" class="form-label small fw-medium">
                                                        {{ __('Slug') }} <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text text-muted">/</span>
                                                        <input type="text"
                                                               id="subSlug{{ $category->id }}"
                                                               name="slug"
                                                               class="form-control sub-slug-input"
                                                               placeholder="hardware"
                                                               required>
                                                    </div>
                                                    <div class="form-text">{{ __('Auto-generated from name.') }}</div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="subColor{{ $category->id }}" class="form-label small fw-medium">{{ __('Color') }}</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="color"
                                                               id="subColor{{ $category->id }}"
                                                               class="form-control form-control-color form-control-sm sub-color-picker"
                                                               value="{{ $category->color ?? '#6366f1' }}"
                                                               style="max-width:48px">
                                                        <input type="text"
                                                               name="color"
                                                               class="form-control sub-color-hex"
                                                               value="{{ $category->color ?? '#6366f1' }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label small fw-medium">{{ __('Status') }}</label>
                                                    <div class="form-check form-switch mt-1">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               name="is_active"
                                                               id="subActive{{ $category->id }}"
                                                               value="1"
                                                               checked>
                                                        <label class="form-check-label small" for="subActive{{ $category->id }}">
                                                            {{ __('Active') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top py-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                                {{ __('Cancel') }}
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-success d-flex align-items-center gap-2">
                                                <i class="ti ti-folder-plus" style="font-size:15px"></i>
                                                {{ __('Save subcategory') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="ti ti-inbox d-block mb-2" style="font-size:32px"></i>
                                {{ __('No categories found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="card-footer bg-white d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2 py-3">
            <span class="text-muted small">
                {{ __('Showing') }} {{ $categories->firstItem() }}–{{ $categories->lastItem() }}
                {{ __('of') }} {{ $categories->total() }} {{ __('categories') }}
            </span>
            {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Select all checkbox
    document.getElementById('selectAll').addEventListener('change', function () {
        document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
    });

    // Auto-generar slug desde nombre (formulario nuevo)
    function toSlug(str) {
        return str.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-');
    }

    const nombreInput = document.getElementById('name');
    const slugInput   = document.getElementById('slug');
    if (nombreInput && slugInput) {
        nombreInput.addEventListener('input', () => {
            slugInput.value = toSlug(nombreInput.value);
        });
    }

    // Sincronizar color picker ↔ hex text (formulario nuevo)
    const colorPicker = document.getElementById('color');
    const colorHex    = document.getElementById('colorHex');
    if (colorPicker && colorHex) {
        colorPicker.addEventListener('input', () => colorHex.value = colorPicker.value);
        colorHex.addEventListener('input', () => {
            if (/^#[0-9A-Fa-f]{6}$/.test(colorHex.value)) colorPicker.value = colorHex.value;
        });
    }

    // Sincronizar color picker <-> hex text (modales editar y subcategoria)
    document.querySelectorAll('.modal').forEach(modal => {
        const picker = modal.querySelector('.edit-color-picker, .sub-color-picker');
        const hex    = modal.querySelector('.edit-color-hex, .sub-color-hex');
        if (picker && hex) {
            picker.addEventListener('input', () => hex.value = picker.value);
            hex.addEventListener('input', () => {
                if (/^#[0-9A-Fa-f]{6}$/.test(hex.value)) picker.value = hex.value;
            });
        }
    });

    // Auto-generar slug en modales de subcategoria
    document.querySelectorAll('.sub-name-input').forEach(nameInput => {
        const modal     = nameInput.closest('.modal');
        const slugInput = modal.querySelector('.sub-slug-input');
        if (slugInput) {
            nameInput.addEventListener('input', () => {
                slugInput.value = toSlug(nameInput.value);
            });
        }
    });
</script>
@endpush
