<x-site-layout>
    <x-slot name="main">
        <h1>Edit subcategory</h1>
       <form action="{{ route('admin.subcategory.update', $subcategory->id) }}" method="post">
            @csrf
            @method('patch')
            <p>
                <label>
                    Change category
                    <select class="text-gray-800" name="category_id">
                        @foreach ($categories as $c)
                            <option class="text-gray-800" value="{{ $c->id }}" 
                                    @if ($c->id == $subcategory->category_id)
                                        {{'selected'}}
                                    @endif
                                >
                                {{ $c->title }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </p>
            <label>
                <input class="text-gray-800" type="text" name="title" value="{{ $subcategory->title }}">
            </label>
            <button type="submit">Submit</button>
       </form>
    </x-slot>
</x-site-layout>
    