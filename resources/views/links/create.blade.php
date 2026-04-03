<x-app-layout>
<x-slot name="header">
    <h2>Create New Link</h2>
</x-slot>
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="p-4">
    
    <form method="POST" action="{{ route('links.store') }}">
        @csrf
        <div class="mb-2">
            <label>Title</label><br>
            <input type="text" name="title" class="border p-1 w-full" required>
        </div>

        <div class="mb-2">
            <label>URL</label><br>
            <input type="url" name="url" class="border p-1 w-full" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
            Create Link
        </button>
    </form>
</div>
</x-app-layout>
