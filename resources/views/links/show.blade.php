<x-app-layout>
<x-slot name="header">
    <h2>Link: {{ $link->title }}</h2>
</x-slot>

<div class="p-4">
    <p><strong>URL:</strong> <a href="{{ $link->url }}" target="_blank" class="text-blue-500 hover:underline">{{ $link->url }}</a></p>
    <p><strong>Category:</strong> {{ $link->category?->name ?? 'None' }}</p>

    <!-- Button + Add Tag -->
    <button onclick="document.getElementById('addTagForm').classList.toggle('hidden')" 
            class="bg-green-500 text-white px-2 py-1 rounded mt-2">+ Add Tag</button>

    <!-- Form to attach Tag -->
    <form id="addTagForm" method="POST" action="{{ route('links.tags.attach', $link->id) }}" class="hidden mt-2">
        @csrf
        <select name="tag_id" class="border p-1">
            <option value=""> Select Tag </option>
            @foreach(\App\Models\Tag::all() as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Assign Tag</button>
    </form>

  
    <h2 class="text-xl font-bold mt-6 mb-2">Tags</h2>
    <ul class="list-disc list-inside">
        @foreach($link->tags as $tag)
            <li>{{ $tag->name }}</li>
        @endforeach
        @if($link->tags->isEmpty())
            <li class="text-gray-500">No tags assigned yet.</li>
        @endif
    </ul>
</div>
<a href="{{ route('links.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow">
    Back
</a>

</x-app-layout>
