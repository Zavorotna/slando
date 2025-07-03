<x-site-layout>
    <x-slot name="main">
        <main class="main_page">
            <div class="main_container">
                <div class="max-w-3xl mx-auto">
                    <h1>Slando</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel consequuntur autem quos est sit libero quia? Voluptatibus quibusdam, harum velit asperiores eius eveniet repudiandae porro officia ut minus accusamus doloribus?</p>
                </div>
            </div>
            <section class="py-5 max-w-7xl mx-auto">
                <h2>Популярні товари</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach ($popularProducts as $popularProduct)
                        <figure class="{{ $popularProduct->id }}">
                            <figcaption>
                                <picture><img src="{{ $popularProduct->getMedia('product')->isNotEmpty() ? $popularProduct->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $popularProduct->title }}"></picture>
                                <h3>{{$popularProduct->title}}</h3>
                                <p>{{ number_format($popularProduct->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                <form action="">
                                    @method('post')
                                    @if($popularProduct->colors->isNotEmpty())
                                        <p class="color flex gap-2">
                                            @foreach ($popularProduct->colors as $c)
                                                <label>
                                                    <input type="radio" name="color" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
                                                </label>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if($popularProduct->sizes->isNotEmpty())
                                        <p class="size">
                                            <select class="" name="sizes">
                                                @foreach ($popularProduct->sizes as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    <div class="flex gap-3 justify-between py-2">
                                        @if($popularProduct->availability == 'available')
                                            <button class="submit-btn" type="submit">В кошик</button>
                                        @endif
                                        <a href="{{ route('site.product', $popularProduct->id) }}">Детальніше</a>
                                    </div>
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
                                <picture><img src="{{ $newProduct->getMedia('product')->isNotEmpty() ? $newProduct->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $newProduct->title }}"></picture>
                                <h3>{{$newProduct->title}}</h3>
                                <p>Ціна: {{ number_format($newProduct->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                <form action="">
                                    @method('post')
                                    @if($newProduct->colors->isNotEmpty())
                                        <p class="color">
                                            @foreach ($newProduct->colors as $c)
                                                <label>
                                                    <input type="radio" name="color" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
                                                </label>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if($newProduct->sizes->isNotEmpty())
                                        <p class="size">
                                            <select class="" name="sizes">
                                                @foreach ($newProduct->sizes as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    <div class="flex gap-3 justify-between py-2">
                                        @if($newProduct->availability == 'available')
                                            <button type="submit">В кошик</button>
                                        @endif
                                        <a href="{{ route('site.product', $newProduct->id) }}">Детальніше</a>
                                    </div>
                                </form>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </section>
        </main>

    </x-slot>
</x-site-layout>
    