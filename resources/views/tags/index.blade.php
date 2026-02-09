<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Manage Tags</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('tags.create') }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
            + Add Tag
        </a>

        <div class="mt-4 space-y-2">
            @foreach($tags as $tag)
                <div class="p-2 border rounded flex justify-between items-center">
                    <span>{{ $tag->name }}</span>
                    <div class="space-x-2">
                        <a href="{{ route('tags.edit', $tag) }}" class="text-yellow-500">Edit</a>
                        <form method="POST" action="{{ route('tags.destroy', $tag) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
   <a href="{{ route('dashboard') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow">
    Back
</a>

</x-app-layout>
