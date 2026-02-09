<x-app-layout>
    <x-slot name="header">
        <h2>Add category</h2>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('categories.store') }}" method="post">
            @csrf

            <label class="block">Name</label>
            <input type="text" name="name" class="border p-2 w-full" required>

            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>
    </div>
</x-app-layout>
