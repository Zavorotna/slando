<x-app-layout>
    <x-slot name="slot">
        <div class="p-6">
            <a class="text-[#fff]  text-2xl inline-block w-sm mb-10 py-3 px-6 duration-300 ease-in border border-white rounded-sm hover:bg-white hover:text-[#000]" href="{{ route('user.products.create') }}">Create</a>
            <table class="text-[#fff] w-full border border-white border-spacing-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Saleprice</th>
                        <th>Availability</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr class="border-b text-center">
                            <td class="p-2 border-r text-left">
                                <p>{{ $p->title }}</p>
                            </td>
                            <td class="p-2 border-r text-left">
                                <p>{{ $p->description }}</p>
                            </td>
                            <td class="p-2 border-r text-left">
                                <p>{{ $p->price }}</p>
                            </td>
                            <td class="p-2 border-r text-left">
                                <p>{{ $p->saleprice }}</p>
                            </td>
                            <td class="p-2 border-r text-left">
                                <p>{{ $p->availability }}</p>
                            </td>
                            <td class="p-2 border-r text-left">
                                <p>{{ $p->discount }}</p>
                            </td>
                            <td class="p-2 border-r">
                                @if($p->deleted_at)
                                    <svg class="inline" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                @else 
                                    <a class="inline-block" href="{{ route('user.products.edit', $p->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                    </a>
                                @endif
                            </td>
                            <td class="p-2 border-r">
                                @if($p->deleted_at)
                                    <form action="{{ route('user.products.restore', $p->id) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M440-320h80v-166l64 62 56-56-160-160-160 160 56 56 64-62v166ZM280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z"/></svg>
                                        </button>
                                    </form>
                                @else 
                                    <form action="{{ route('user.products.destroy', $p) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
    