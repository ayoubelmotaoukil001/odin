<x-app-layout>
<x-slot :header>
    <h2>edit category</h2>
</x-slot>

    <form action="{{ route ('categories.update', $category->id)}}" method ="post" class="p-4">
        @csrf
        @method('put')
        <div >
            <label class="block"> name</label>
            <input type="text" name="name" id="name" class="border p-2 w-full bg-black" required value="{{$category->name}}"> 
            @error("name")
            <p class="text-red-500 text-sm">{{ ($message)}}</p>
            @enderror
        </div>
     
        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Save</button>
    </form>

</x-app-layout>  