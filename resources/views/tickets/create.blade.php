@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <form action="{{ route('tickets.store') }}" method="POST">
            <div class="row">

                @csrf
                <div class="col-md-8">
                    @include('partials.alerts')

                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-plus-circle me-2"></i> Create new ticket
                            </h5>
                        </div>

                        <div class="card-body">
                            {{-- Título --}}
                            <div class="mb-3">
                                <label for="title" class="form-label fw-semibold">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title') }}"
                                       placeholder="Example: Error logging in"
                                       required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">
                                    Description <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="5"
                                          placeholder="Describe the problem in detail..."
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            {{-- Categoría --}}
                            {{-- Categoría padre --}}
                            <div class="mb-3">
                                <label for="category_id" class="form-label small fw-medium">
                                    {{ __('Category') }} <span class="text-danger">*</span>
                                </label>
                                <select id="category_id" name="category_id" class="form-select" required>
                                    <option value="">{{ __('Select a category…') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                                data-has-children="{{ $category->children->isNotEmpty() ? '1' : '0' }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Subcategoría (oculto hasta que el padre tenga hijos) --}}
                            <div class="mb-3" id="subcategoryWrapper" style="display:none">
                                <label for="subcategory_id" class="form-label small fw-medium">
                                    {{ __('Subcategory') }}
                                </label>
                                <select id="subcategory_id" name="subcategory_id" class="form-select">
                                    <option value="">{{ __('Select a subcategory…') }}</option>
                                </select>
                            </div>

                            {{-- Prioridad con botones de radio estilo Bootstrap --}}
                            <div class="mb-3">
                                <label class="form-label">Priority</label>
                                <div class="btn-group form-control" role="group">
                                    @foreach ($priorities as $priority)
                                        <input type="radio" class="btn-check" name="priority_level"
                                               id="priority-{{ $priority->value }}"
                                               value="{{ $priority->value }}"
                                            @checked(old('priority', 'medium') == $priority->value)>
                                        <label class="btn btn-outline-secondary" for="priority-{{ $priority->value }}">
                                            {{ $priority->label() }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="due_at" class="form-label">Expiration date</label>
                                <input type="datetime-local" name="due_at" id="due_at"
                                       class="form-control"
                                       value="{{ old('due_at', $defaultDueDate) }}">
                                <small class="text-muted">It's calculated based on priority, but you can change it.</small>
                            </div>

                            {{-- Asignar a equipo (solo admins/supervisores) --}}
                            @auth
                                <div class="mb-3">
                                    <label for="team_id" class="form-label fw-semibold">
                                        Assign to team
                                    </label>
                                    <select class="form-select @error('team_id') is-invalid @enderror"
                                            id="team_id"
                                            name="team_id">
                                        <option value="">Unassigned</option>
                                        @foreach($teams as $team)
                                            <option
                                                value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-flex gap-2 justify-content-end pt-3 border-top mt-4">
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg"></i> Create Ticket
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    window.slaHours = @json(
        collect($priorities)->mapWithKeys(fn($p) => [$p->value => $p->slaHours()])
    );

    document.addEventListener('DOMContentLoaded', function () {

        // ── Subcategorías ────────────────────────────────────────────
        const subcategories = {
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    {{ $category->id }}: [
                        @foreach ($category->children as $child)
                            { id: {{ $child->id }}, name: "{{ addslashes($child->name) }}" },
                        @endforeach
                    ],
                @endif
            @endforeach
        };

        const categorySelect     = document.getElementById('category_id');
        const subcategorySelect  = document.getElementById('subcategory_id');
        const subcategoryWrapper = document.getElementById('subcategoryWrapper');

        categorySelect.addEventListener('change', function () {
            const selectedId = parseInt(this.value);
            const children   = subcategories[selectedId];

            subcategorySelect.innerHTML = '<option value="">{{ __("Select a subcategory…") }}</option>';

            if (children && children.length > 0) {
                children.forEach(child => {
                    const opt       = document.createElement('option');
                    opt.value       = child.id;
                    opt.textContent = child.name;
                    subcategorySelect.appendChild(opt);
                });
                subcategoryWrapper.style.display = 'block';
                subcategorySelect.setAttribute('required', 'required');
            } else {
                subcategoryWrapper.style.display = 'none';
                subcategorySelect.removeAttribute('required');
            }
        });

        const oldCategoryId = {{ old('category_id', 'null') }};
        const oldSubId      = {{ old('subcategory_id', 'null') }};

        if (oldCategoryId) {
            categorySelect.value = oldCategoryId;
            categorySelect.dispatchEvent(new Event('change'));
            if (oldSubId) subcategorySelect.value = oldSubId;
        }

        // ── Fecha según prioridad ────────────────────────────────────
        // ✅ Declaradas aquí dentro, donde el DOM ya existe
        const priorityInputs = document.querySelectorAll('input[name="priority_level"]');
        const dueDateInput   = document.getElementById('due_at');

        function calculateDueDate(priorityValue) {
            const hours = window.slaHours[priorityValue];
            if (!hours) return '';

            const now = new Date();
            now.setHours(now.getHours() + hours);

            return [
                now.getFullYear(),
                String(now.getMonth() + 1).padStart(2, '0'),
                String(now.getDate()).padStart(2, '0'),
            ].join('-') + 'T' + [
                String(now.getHours()).padStart(2, '0'),
                String(now.getMinutes()).padStart(2, '0'),
            ].join(':');
        }

        priorityInputs.forEach(input => {
            input.addEventListener('change', function () {
                if (this.checked) {
                    const newDate = calculateDueDate(this.value);
                    if (newDate) dueDateInput.value = newDate;
                }
            });
        });

    }); // ← único cierre de DOMContentLoaded
</script>
@endpush
