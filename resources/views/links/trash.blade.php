<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-red-600">Trash Bin (Deleted Links)</h2>
            <a href="{{ route('links.index') }}" class="text-blue-600 hover:underline">Back to All Links</a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-3">
            @forelse($links as $link)
                <div class="p-4 bg-white border border-red-100 rounded-lg shadow-sm flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-800">{{ $link->title }}</span>
        <!--    undestand what is this -->
                        <span class="text-xs text-gray-400 italic">Deleted at: {{ $link->deleted_at->diffForHumans() }}</span> 
                      
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <form action="{{ route('links.restore', $link->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 text-sm transition">
                                Restore
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white border rounded-lg">
                    <p class="text-gray-500">Trash is empty. No deleted links found.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>