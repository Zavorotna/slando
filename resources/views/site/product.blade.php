<x-site-layout>
    <x-slot name="main">
        <h1>{{ $product->title }}</h1> 
        <p>{{ $product->description }}</p>
        <p>Ціна: {{$product->saleprice}} грн <s>{{$product->price}}</s></p>
        @if($product->availabillity == 'availlable')
            <p>В наявності</p>
        @else 
            <p>Немає в наявності</p>
        @endif
        <p>Продавець: {{ $product->user->customer->name }}</p>
        <a href="">В кошик</a>
    </x-slot>
</x-site-layout>
    