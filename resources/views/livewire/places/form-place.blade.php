<div class="max-w-3xl mx-auto p-6">

    <!-- Card Form -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">
            {{ $isEditing ? 'Editar Post' : 'Crear Sitio' }}
        </h2>

        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-4">

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre del Sitio
                </label>
                <input
                    type="text"
                    wire:model="name"
                    placeholder="Escribe el nombre del sitio"
                    class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Código del Sitio
                </label>
                <input
                    type="text"
                    wire:model="code"
                    placeholder="Escribe el código del sitio"
                    class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >
                @error('code')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <div class="flex justify-end">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-md transition"
                >
                    {{ $isEditing ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Posts -->
    <div class="space-y-4">
        @foreach ($places as $post)
            <div class="bg-white shadow rounded-lg p-5 flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $post->title }}
                    </h3>
                    <p class="text-gray-600 mt-1">
                        {{ $post->content }}
                    </p>
                </div>

                <div class="flex gap-2">
                    <button
                        wire:click="edit({{ $post->id }})"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                    >
                        Editar
                    </button>

                    <button
                        wire:click="delete({{ $post->id }})"
                        class="text-red-600 hover:text-red-800 text-sm font-medium"
                    >
                        Eliminar
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</div>
