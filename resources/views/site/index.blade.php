<x-site-layout>
    <x-slot name="main">
        <main class="main_page">
            <div class="main_container">
                <div class="max-w-3xl mx-auto">
                    <h1>Slando</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel consequuntur autem quos est sit libero quia? Voluptatibus quibusdam, harum velit asperiores eius eveniet repudiandae porro officia ut minus accusamus doloribus?</p>
                </div>
            </div>
            <div class="py-5 max-w-7xl mx-auto">
                <section>
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
                                    @if(Auth::check())
                                        @if($user && $user->likedProducts->contains($popularProduct))
                                            <form action="{{ route('site.removeLiked') }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $popularProduct->id }}">
                                                <button type="submit">Видалити з вподобаних</button>
                                            </form>
                                        @else 
                                            <form action="{{ route('site.liked') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $popularProduct->id }}">
                                                <button type="submit">Вподобати</button>
                                            </form>
                                        @endif
                                    @endif
                                </figcaption>
                            </figure>
                            @endforeach
                        </div>
                    </section>
                    @if($newProducts->isNotEmpty())
                        <section>
                            <h2>Новинки</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                                @foreach ($newProducts as $newProduct)
                                <figure class="{{$newProduct->id}}">
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
                                        @if(Auth::check())
                                            @if($user && $user->likedProducts->contains($newProduct))
                                                <form action="{{ route('site.removeLiked') }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $newProduct->id }}">
                                                    <button type="submit">Видалити з вподобаних</button>
                                                </form>
                                            @else 
                                                <form action="{{ route('site.liked') }}" method="post">
                                                    @csrf
                                                    @method('post')
                                                    <input type="hidden" name="id" value="{{ $newProduct->id }}">
                                                    <button type="submit">Вподобати</button>
                                                </form>
                                            @endif
                                        @endif
                                    </figcaption>
                                </figure>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </main>

    </x-slot>
</x-site-layout>
    