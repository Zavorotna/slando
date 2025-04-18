<x-site-layout>
    <x-slot name="main">
        <a href="{{ route('admin.subsubcategory.create') }}">Create</a>
        <table>
            @foreach ($subsubcategories as $s)
                <tr>
                    <td>
                        <p>Category: {{ $s->subcategory_title }}</p>
                    </td>
                    <td>
                        <p>Title: {{ $s->title }}</p>
                    </td>
                    <td><a href="{{ route('admin.subsubcategory.edit', $s->id) }}">Edit</a></td>
                    <td>
                        <form action="{{ route('admin.subsubcategory.destroy', $s->id) }}" method="post">
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
    