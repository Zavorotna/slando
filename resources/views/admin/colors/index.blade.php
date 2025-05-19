<x-app-layout>
    <x-slot name="slot">
        <div class="p-6">
            <a class="text-[#fff]  text-2xl inline-block w-sm mb-10 py-3 px-6 duration-300 ease-in border border-white rounded-sm hover:bg-white hover:text-[#000]" href="{{ route('admin.color.create') }}">Create</a>
            <table class="text-[#fff] w-full border border-white border-spacing-0">
                <thead class="border-b">
                    <tr>
                        <th class="border-r p-2">Title</th>
                        <th class="border-r p-2">Hex</th>
                        <th class="border-r p-2">Edit</th>
                        <th class="border-r p-2">Delete</th>
                    </tr>
                </thead>
                @foreach ($colors as $c)
                    <tr class="border-b text-center">
                        <td class="p-2 border-r text-left">
                            <p>{{ $c->name }}</p>
                        </td>
                        <td class="p-2 border-r text-center">
                            <span class="inline-block w-24 h-5" style="background-color: {{ $c->hex}}"></span>
                        </td>
                        <td class="p-2 border-r">
                            <a class="inline-block" href="{{ route('admin.color.edit', $c->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                            </a>
                        </td>
                        <td class="p-2 border-r">
                            @if($c->deleted_at)
                                <form action="{{ route('admin.color.restore', $c->id) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M440-320h80v-166l64 62 56-56-160-160-160 160 56 56 64-62v166ZM280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg>
                                    </button>
                                </form>
                            @else 
                                <form action="{{ route('admin.color.destroy', $c->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </x-slot>
</x-app-layout>
    