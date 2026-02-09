<x-app-layout>
<x-slot name="header">
    <h2>Welcome {{ auth()->user()->name }}</h2>
</x-slot>

<div class="p-6 space-y-4">
    <a href="{{ route('categories.index') }}" class="bg-green-500 text-white px-4 py-2 rounded">
        Manage Categories
    </a>
    <a href="{{ route('links.index') }}" class="bg-black px-4 py-2 rounded text-white m-5">
        Manage Links
    </a>
     <a href="{{ route('tags.index') }}" class="bg-yellow-900 px-4 py-2 rounded text-white m-5">
        Manage tags
    </a>
</div>
</x-app-layout>
