<x-app-layout>
    <x-slot name="slot">
        <div class="p-6">
            <table class="w-full border border-black border-spacing-0">
                <thead>
                    <tr class="border-black text-center">
                        <th class="p-2 border-black border">ПІБ</th>
                        <th class="p-2 border-black border">Телефон</th>
                        <th class="p-2 border-black border">Адреса</th>
                        <th class="p-2 border-black border">Товар</th>
                        <th class="p-2 border-black border">Колір</th>
                        <th class="p-2 border-black border">Розмір</th>
                        <th class="p-2 border-black border">Кількість</th>
                        <th class="p-2 border-black border">Сума</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr class="border-black text-center">
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->customer->name }} {{ $o->customer->surname }}</p>
                            </td>
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->customer->phone }}</p>
                            </td>
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->address }}</p>
                            </td>
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->product->title }}</p>
                            </td>
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->color }}</p>
                            </td>
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->size }}</p>
                            </td>
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->count }}</p>
                            </td>
                            <td class="p-2 border-black border-r text-left">
                                <p>{{ $o->total_price }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
    