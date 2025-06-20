<x-site-layout>
    <x-slot name="main">
        <h1>{{ $product->title }}</h1> 
        <p>{{ $product->description }}</p>
        <p>Ціна: {{$product->saleprice}} грн <s>{{$product->price}}</s></p>
        @if($product->availability == 'available')
            <p>В наявності</p>
        @else 
            <p>Немає в наявності</p>
        @endif
        <p>Продавець: {{ $product->user->customer->name }}</p>
        <form action="">
            @method('post')
            @if($product->colors->isNotEmpty())
                <p>
                    @foreach ($product->colors as $c)
                        <label>
                            <input type="radio" name="color" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
                        </label>
                    @endforeach
                </p>
            @endif
            @if($product->sizes->isNotEmpty())
                <p>
                    <select class="text-gray-800" name="sizes">
                        @foreach ($product->sizes as $s)
                            <option value="{{ $s->id }}">{{ $s->name}}</option>
                        @endforeach
                    </select>
                </p>
            @endif
            @if($product->availability == 'available')
                <button type="submit">В кошик</button>
            @endif
            <a href="{{ route('site.product', $product->id) }}">Детальніше</a>
        </form>
    </x-slot>
</x-site-layout>
    