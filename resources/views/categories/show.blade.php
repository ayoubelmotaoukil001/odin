<x-app-layout>
<x-slot name="header">
    <h2>Category: {{ $category->name }}</h2>
</x-slot>

<div class="p-4">
    <p><strong>Name: {{ $category->name }}</strong></p>

  
    <button onclick="document.getElementById('addLinkForm').classList.toggle('hidden')" 
            class="bg-green-500 text-white px-2 py-1 rounded mt-2">
        add Link
    </button>

 
    <form id="addLinkForm" class="hidden mt-2" method="POST" action="{{ route('categories.links.attach', $category->id) }}">
        @csrf
        <select name="link_id" class="border p-1">
            <option value=""> Select Link </option>
            @foreach(\App\Models\Link::whereNull('category_id')->get() as $link)
                <option value="{{ $link->id }}">{{ $link->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Add</button>
    </form>

    
    <h2 class="text-xl font-bold mt-6 mb-2">Links in this Category</h2>
    <ul class="list-disc list-inside">
        @foreach($category->links as $link)
            <li class="mb-1">
                <a href="{{ $link->url }}" target="_blank" class="text-blue-500 hover:underline">
                    {{ $link->title }}
                </a>
            </li>
        @endforeach
        @if($category->links->isEmpty())
            <li class="text-gray-500">No links assigned yet.</li>
        @endif
    </ul>
</div>
<a href="{{ route('categories.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow">
    Back
</a>
</x-app-layout>
