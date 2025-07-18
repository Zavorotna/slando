<x-app-layout>
    <x-slot name="slot">
        <div class="p-6">
            <h1 class="text-center p-2 text-3xl">Products</h1>
            <table class="w-full border-spacing-0">
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
                            <td class="p-2  text-left">
                                <p>{{ $p->title }}</p>
                            </td>
                            <td class="p-2  text-left">
                                <p>{{ $p->description }}</p>
                            </td>
                            <td class="p-2  text-left">
                                <p>{{ $p->price }}</p>
                            </td>
                            <td class="p-2  text-left">
                                <p>{{ $p->saleprice }}</p>
                            </td>
                            <td class="p-2  text-left">
                                <p>{{ $p->availability }}</p>
                            </td>
                            <td class="p-2  text-left">
                                <p>{{ $p->discount }}</p>
                            </td>
                            <td class="p-2 ">
                                <form action="{{ route('admin.products.destroy', $p->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="red"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->withQueryString()->onEachSide(2)->links('vendor.pagination.custom') }}
        </div>
    </x-slot>
</x-app-layout>
    