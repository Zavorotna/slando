<x-site-layout>
    <x-slot name="main">
        <a href="{{ route('admin.category.create') }}">Create</a>
        @foreach ($categories as $c)
            <div>
                <p>Title: {{ $c->title }}</p>
                <a href="{{ route('admin.category.edit', $c->id) }}">Edit</a>
                <form action="{{ route('admin.category.destroy', $c->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">Delete</button>
                </form>
            </div>
        @endforeach
    </x-slot>
</x-site-layout>
    