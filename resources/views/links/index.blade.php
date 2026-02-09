<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Manage Links</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('links.create') }}" 
           class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
           + Add Link
        </a>

        <div class="mt-4 space-y-2">
            @foreach($links as $link)
                <div class="p-2 border rounded flex justify-between items-center">
                    <span>{{ $link->title }}</span>
                    <a href="{{ route('links.show', $link->id) }}" 
                       class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                       Show
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <a href="{{ route('dashboard') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow">
    Back
    </a>
</x-app-layout>
