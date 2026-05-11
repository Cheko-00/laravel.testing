@extends('layouts.app')

@section('content')
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                        @include('partials.alerts')

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            {{-- Campo: name --}}
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       autofocus>
                                <small class="text-muted">Examples: Technology, Sports, Music, etc..</small>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Campo: slug (se genera automáticamente) --}}
                            <div class="mb-4">
                                <label for="slug" class="form-label fw-semibold">
                                    Slug <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug') }}"
                                       readonly
                                       style="background-color: #f8f9fa; cursor: not-allowed;">
                                <small class="text-muted">
                                    <i class="bi bi-magic"></i> It is generated automatically when you type the name.
                                </small>
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Campo: color --}}
                            <div class="mb-4">
                                <label for="color" class="form-label fw-semibold">
                                    Color <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="color"
                                           class="form-control form-control-color @error('color') is-invalid @enderror"
                                           id="color_picker"
                                           name="color"
                                           value="{{ old('color', '#0d6efd') }}"
                                           style="width: 60px; height: 38px; cursor: pointer;">
                                    <input type="text"
                                           class="form-control @error('color') is-invalid @enderror"
                                           id="color_text"
                                           value="{{ old('color', '#0d6efd') }}"
                                           placeholder="#RRGGBB"
                                           style="flex: 1;">
                                </div>
                                <small class="text-muted">SSelect a representative color for the category</small>
                                @error('color')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Campo: is_active --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Estado</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox"
                                           class="form-check-input @error('is_active') is-invalid @enderror"
                                           id="is_active"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                           style="width: 48px; height: 24px;">
                                    <label class="form-check-label ms-2" for="is_active" id="status_label">
                                        Activo
                                    </label>
                                </div>
                                <small class="text-muted">If it is inactive, the category will not be displayed in the system.</small>
                                @error('is_active')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Parent category <span class="text-muted">(optional)</span></label>
                                <select name="parent_id" class="form-select">
                                    <option value="">— None (top-level) —</option>
                                    @foreach(\App\Models\Category::whereNull('parent_id')->orderBy('name')->get() as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ request('parent') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Botones --}}
                            <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                                <a href="{{ route('categories.index') }}" class="btn btn-light px-4">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Save Category
                                </button>
                            </div>
                        </form>


                {{-- Preview de cómo se verá --}}
                <div class="card border shadow-sm mt-4 bg-light">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Preview</h6>
                        <div class="d-flex align-items-center gap-3 p-3 rounded" id="previewCard">
                            <div class="rounded-2 d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:50px; height:50px; background-color: #0d6efd; font-size:1.2rem;">
                                ?
                            </div>
                            <div>
                                <h6 class="mb-0" id="previewName">Category name</h6>
                                <small class="text-muted" id="previewSlug">example-slug</small>
                            </div>
                            <span class="badge bg-success ms-auto" id="previewStatus">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        function generateSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9\s-]/g, "")
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }

        nameInput.addEventListener('input', function() {
            const slug = generateSlug(this.value);
            slugInput.value = slug;

            // Actualizar preview
            document.getElementById('previewName').textContent = this.value || 'Category name';
            document.getElementById('previewSlug').textContent = slug || 'example-slug';

            // Actualizar iniciales en el preview
            const initials = this.value ? this.value.substring(0, 2).toUpperCase() : '?';
            document.querySelector('#previewCard .rounded-2').textContent = initials;
        });

        // Sincronizar color picker con campo texto
        const colorPicker = document.getElementById('color_picker');
        const colorText = document.getElementById('color_text');
        const previewIcon = document.querySelector('#previewCard .rounded-2');

        function updateColor(color) {
            previewIcon.style.backgroundColor = color;
        }

        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
            updateColor(this.value);
        });

        colorText.addEventListener('input', function() {
            let color = this.value;
            if (/^#[0-9A-F]{6}$/i.test(color)) {
                colorPicker.value = color;
                updateColor(color);
            }
        });

        // Cambiar estado del switch
        const statusToggle = document.getElementById('is_active');
        const statusLabel = document.getElementById('status_label');
        const previewStatus = document.getElementById('previewStatus');

        statusToggle.addEventListener('change', function() {
            const isActive = this.checked;
            statusLabel.textContent = isActive ? 'Active' : 'Inactive';
            previewStatus.textContent = isActive ? 'Active' : 'Inactive';
            previewStatus.className = isActive ? 'badge bg-success ms-auto' : 'badge bg-secondary ms-auto';
        });

        // Inicializar valores
        if (nameInput.value) {
            slugInput.value = generateSlug(nameInput.value);
        }

        // Rotar chevron al expandir/colapsar
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(row => {
            const target = document.querySelector(row.dataset.bsTarget);
            if (!target) return;
            target.addEventListener('show.bs.collapse', () => {
                row.querySelector('.chevron-icon')?.style.setProperty('transform', 'rotate(90deg)');
            });
            target.addEventListener('hide.bs.collapse', () => {
                row.querySelector('.chevron-icon')?.style.setProperty('transform', 'rotate(0deg)');
            });
        });

    </script>
@endpush

