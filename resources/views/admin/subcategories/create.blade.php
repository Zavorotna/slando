<x-site-layout>
    <x-slot name="main">
        <h1>Create subcategory</h1>
       <form action="{{ route('admin.subcategory.store') }}" method="post">
            @csrf
            <p>
                <label>
                    Select category
                    <select class="text-gray-800" name="category_id">
                        @foreach ($categories as $c)
                            <option class="text-gray-800" value="{{ $c->id }}">{{ $c->title }}</option>
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
    