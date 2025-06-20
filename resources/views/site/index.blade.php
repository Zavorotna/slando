<x-site-layout>
    <x-slot name="main">
        <main class="max-w-7xl mx-auto py-5">
            <h1>Slando</h1>
            <section>
                <h2>Популярні товари</h2>
                <div class="grid grid-cols-4 gap-5">
                    @foreach ($popularProducts as $popularProduct)
                        <figure>
                            <figcaption>
                                <a href=""></a>
                                <img src="{{ $popularProduct->getMedia('product')->isNotEmpty() ? $popularProduct->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $popularProduct->title }}">
                                <h3>{{$popularProduct->title}}</h3>
                                <p>Ціна: {{ number_format($popularProduct->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                {{-- @dd($popularProduct) --}}
                                <form action="">
                                    @method('post')
                                    @if($popularProduct->colors->isNotEmpty())
                                        <p>
                                            @foreach ($popularProduct->colors as $c)
                                                <label>
                                                    <input type="radio" name="color" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
                                                </label>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if($popularProduct->sizes->isNotEmpty())
                                        <p>
                                            <select class="text-gray-800" name="sizes">
                                                @foreach ($popularProduct->sizes as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    @if($popularProduct->availability == 'available')
                                        <button type="submit">В кошик</button>
                                    @endif
                                    <a href="{{ route('site.product', $popularProduct->id) }}">Детальніше</a>
                                </form>
                            </figcaption>
                        </figure>
                        @endforeach
                    </div>
                </section>
                <section>
                    <h2>Новинки</h2>
                    <div class="grid grid-cols-4 gap-5">
                        @foreach ($newProducts as $newProduct)
                        <figure>
                            <figcaption>
                                <a href=""></a>
                                <img src="{{ $newProduct->getMedia('product')->isNotEmpty() ? $newProduct->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $newProduct->title }}">
                                <h3>{{$newProduct->title}}</h3>
                                <p>Ціна: {{ number_format($newProduct->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                <form action="">
                                    @method('post')
                                    @if($newProduct->colors->isNotEmpty())
                                        <p>
                                            @foreach ($newProduct->colors as $c)
                                                <label>
                                                    <input type="radio" name="color" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
                                                </label>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if($newProduct->sizes->isNotEmpty())
                                        <p>
                                            <select class="text-gray-800" name="sizes">
                                                @foreach ($newProduct->sizes as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    @if($newProduct->availability == 'available')
                                        <button type="submit">В кошик</button>
                                    @endif
                                    <a href="{{ route('site.product', $newProduct->id) }}">Детальніше</a>
                                </form>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </section>
        </main>

    </x-slot>
</x-site-layout>
    