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
                                <form action="{{ route('admin.products.destroy', $p->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
    