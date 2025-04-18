<x-site-layout>
    <x-slot name="main">
        <h1>Create subsubcategory</h1>
       <form action="{{ route('admin.subsubcategory.store') }}" method="post">
            @csrf
            <p>
                <label>
                    Select subcategory
                    <select class="text-gray-800" name="subcategory_id">
                        @foreach ($subcategories as $sc)
                            <option class="text-gray-800" value="{{ $sc->id }}">{{ $sc->title }}</option>
                        @endforeach
                    </select>
                </label>
            </p>
            <p>
                <label>
                    Title
                    <input class="text-gray-800" type="text" name="title">
                </label>
            </p>
            <button type="submit">Submit</button>
       </form>
    </x-slot>
</x-site-layout>
    