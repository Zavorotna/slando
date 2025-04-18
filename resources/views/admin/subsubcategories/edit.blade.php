<x-site-layout>
    <x-slot name="main">
        <h1>Edit subsubcategory</h1>
       <form action="{{ route('admin.subsubcategory.update', $subsubcategory->id) }}" method="post">
            @csrf
            @method('patch')
            <p>
                <label>
                    Change subcategory
                    <select class="text-gray-800" name="subcategory_id">
                        @foreach ($subcategories as $sc)
                            <option class="text-gray-800" value="{{ $sc->id }}" {{ ($sc->id != $subsubcategory->subcategory_id) ?: 'selected'}}>
                                {{ $sc->title }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </p>
            <label>
                <input class="text-gray-800" type="text" name="title" value="{{ $subsubcategory->title }}">
            </label>
            <button type="submit">Submit</button>
       </form>
    </x-slot>
</x-site-layout>
    