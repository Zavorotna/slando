<x-app-layout>
    <x-slot name="slot">
        <div class="p-6">
            <a class="text-2xl inline-block w-sm mb-10 py-3 px-6 duration-300 ease-in border border-black rounded-sm hover:bg-white hover:text-[#000]" href="{{ route('admin.subcategory.create') }}">Create</a>
            <table class="w-full border-spacing-0">
                <thead>
                    <tr class="text-center">
                        <td class="p-2 ">Category</td>
                        <td class="p-2 ">Title</td>
                        <td class="p-2 ">Edit</td>
                        <td class="p-2 ">Delete</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subcategories as $s)
                        <tr class="text-center">
                            <td class="p-2 text-left">
                                <p>{{ $s->category_title }}</p>
                            </td>
                            <td class="p-2 text-left">
                                <p>{{ $s->title }}</p>
                            </td>
                            <td class="p-2 ">
                                <a class="inline-block" href="{{ route('admin.subcategory.edit', $s->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="green"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                </a>
                            </td>
                            <td class="p-2 ">
                                <form action="{{ route('admin.subcategory.destroy', $s->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="red"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                    
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $subcategories->withQueryString()->onEachSide(2)->links('vendor.pagination.custom') }}
        </div>
    </x-slot>
</x-app-layout>
    