<x-site-layout>
    <x-slot name="main">
        <main class="max-w-7xl mx-auto">
            <h1>Вподобані товари</h1>
            <section>
                <div class="grid grid-cols-4 gap-5">
                    @foreach ($likedProducts as $p)
                        <figure>
                            <figcaption>
                                <a href=""></a>
                                <img src="{{ $p->getMedia('product')->isNotEmpty() ? $p->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $p->title }}">
                                <h3>{{$p->title}}</h3>
                                <p>Ціна: {{ number_format($p->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                <form action="">
                                    @method('post')
                                    @csrf
                                    @if($p->colors->isNotEmpty())
                                        <p>
                                            @foreach ($p->colors as $c)
                                                <label>
                                                    <input type="radio" name="color" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
                                                </label>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if($p->sizes->isNotEmpty())
                                        <p>
                                            <select class="text-gray-800" name="sizes">
                                                @foreach ($p->sizes as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    @if($p->availability == 'available')
                                        <button type="submit">В кошик</button>
                                    @endif
                                    <a href="{{ route('site.product', $p->id) }}">Детальніше</a>
                                </form>
                                {{-- <form action="{{ route('site.liked') }}" method="post">
                                    @csrf
                                    @method('post')
                                    <input type="hidden" name="id" value="{{ $p->id }}">
                                    <button type="submit">Вподобати</button>
                                </form> --}}
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </section>
        </main>

    </x-slot>
</x-site-layout>
    