<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Manage Your Links</h2>
    </x-slot>

    <div class="p-6 container mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('links.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition font-semibold">
                + Add New Link
            </a>
            <a href="{{ route('links.favorites') }}" class="text-yellow-600 hover:text-yellow-700 font-bold flex items-center">
                <span class="mr-1">★</span> View My Favorites
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Title</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($links as $link)
                    <tr class="hover:bg-gray-50 transition" x-data="{ openShare: false }">
                        <td class="px-5 py-4 text-sm flex items-center space-x-3">
                            <form action="{{ route('links.favorite', $link) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-2xl focus:outline-none transition transform hover:scale-120">
                                    @if($link->isFavoritedBy(auth()->user()))
                                        <span class="text-yellow-500" title="Remove from favorites">★</span>
                                    @else
                                        <span class="text-gray-300 hover:text-yellow-400" title="Add to favorites">☆</span>
                                    @endif
                                </button>
                            </form>
                            <p class="text-gray-900 font-medium">{{ $link->title }}</p>
                        </td>
                        <td class="px-5 py-4 text-right space-x-3">
                            <button @click="openShare = true" type="button" class="text-indigo-600 hover:text-indigo-900 font-bold transition">
                                Share
                            </button>

                            <a href="{{ route('links.edit', $link) }}" class="text-yellow-600 hover:text-yellow-900 font-bold">Edit</a>

                            <form method="POST" action="{{ route('links.destroy', $link) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold" onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>

                            <div x-show="openShare" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                                <div class="flex items-center justify-center min-h-screen px-4">
                                    <div class="fixed inset-0 bg-black opacity-50 transition-opacity" @click="openShare = false"></div>
                                    <div class="bg-white rounded-lg shadow-xl sm:max-w-lg sm:w-full p-6 z-50 text-left relative">
                                         <h3 class="text-lg font-bold mb-4">Share: {{ $link->title }}</h3>
                                         <form action="{{ route('links.share', $link) }}" method="POST">
                                            @csrf
                                            <input type="email" name="email" class="w-full border rounded p-2 mb-4" placeholder="Email" required>
                                            <select name="permession" class="w-full border rounded p-2 mb-4">
                                                <option value="view">View</option>
                                                <option value="edit">Edit</option>
                                            </select>
                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="openShare = false" class="bg-gray-200 px-4 py-2 rounded">Cancel</button>
                                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Send</button>
                                            </div>
                                         </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-5 py-10 text-center text-gray-500 font-medium">
                            No links found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>