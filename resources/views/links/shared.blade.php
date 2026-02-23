<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Shared With Me</h2>
    </x-slot>

    <div class="p-6 container mx-auto">
        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Shared By</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Permission</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($links as $link)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 text-sm font-medium text-gray-900">{{ $link->title }}</td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ $link->user->name }}</td>
                        <td class="px-5 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $link->pivot->permession == 'edit' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($link->pivot->permession) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right space-x-3 text-sm">
                            <a href="{{ $link->url }}" target="_blank" class="text-indigo-600 hover:underline">Visit</a>
                            
                            @if($link->pivot->permession == 'edit')
                                <a href="{{ route('links.edit', $link) }}" class="text-yellow-600 font-bold">Edit</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-gray-500">No links shared with you.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>