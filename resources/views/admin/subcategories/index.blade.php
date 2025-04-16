<x-site-layout>
    <x-slot name="main">
        <a href="{{ route('admin.subcategory.create') }}">Create</a>
        <table>
            @foreach ($subcategories as $s)
                <tr>
                    <td>
                        <p>Category: {{ $s->category_title }}</p>
                    </td>
                    <td>
                        <p>Title: {{ $s->title }}</p>
                    </td>
                    <td><a href="{{ route('admin.subcategory.edit', $s->id) }}">Edit</a></td>
                    <td>
                        <form action="{{ route('admin.subcategory.destroy', $s->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </x-slot>
</x-site-layout>
    