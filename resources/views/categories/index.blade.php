<x-app-layout>
<x-slot name="header">
    <h2>list de categories</h2>
</x-slot>

<div class="py-4">
    <a href="{{ route('categories.create')}}" class="text-blue-500"> add a category</a>
</div>
<table  class="py-4">
    <thead>
        <tr>
            <th class="border px-2 py-1">ID</th>
            <th class="border px-2 py-1">name</th>
            <th class="border px-2 py-1">controll</th>
        </tr>
    </thead>
    <tbody> 
        @foreach($categories as $categorie)
        <tr>
            <td class="border px-2 py-1">{{$categorie->id}}</td>
            <td class="border px-2 py-1">{{$categorie->name}}</td>
            <td class=" border px-2 py-1">
                 <a href="{{route('categories.edit',$categorie->id)}}" class="text-green-500"> edit</a>
                 <form action="{{route ('categories.destroy',$categorie->id)}}" method="post" style="display: inline;">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="text-red-500"> delete</button>
                  <a href="{{ route('categories.show', $categorie->id) }}" class="text-blue-500">show</a>

                 </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('dashboard') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow">
    Back
</a>



</x-app-layout>  