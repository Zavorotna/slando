<x-site-layout>
    <x-slot name="main">
        <main class="max-w-7xl mx-auto">
            <h1>{{__('index.liked_h1')}}</h1>
            <section>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach ($likedProducts as $p)
                        <figure class="product-card">
                            <figcaption>
                                <img class="product-main-image" src="{{ $p->getMedia('product')->isNotEmpty() ? $p->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $p->title }}">
                                <h3>{{$p->title}}</h3>
                                <p>{{ number_format($p->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                <form action="">
                                    @method('post')
                                    @csrf
                                    @if($p->colors->isNotEmpty())
                                        <p class="color">
                                            @foreach ($p->colors as $ind => $c)
                                                @php
                                                    $colorPhotoUrls = $p->media->filter(function($img) use ($c) {
                                                        return $img->getCustomProperty('color_id') == $c->id;
                                                    })->map(function($img) {
                                                        return $img->getUrl();
                                                    })->values();
                                                @endphp
                                                <label>
                                                    <input type="radio" name="color" data-color-id="{{ $c->id }}" data-image-urls="{{$colorPhotoUrls->isNotEmpty() ? $colorPhotoUrls->first() : asset('/img/no-img.png')}}" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
                                                </label>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if($p->sizes->isNotEmpty())
                                        <p class="size">
                                            <select class="" name="sizes">
                                                @foreach ($p->sizes as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name}}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    <div class="flex justify-between gap-3 py-2">
                                        @if($p->availability == 'available')
                                            <button type="submit">{{__('index.cart_cta')}}</button>
                                        @endif
                                        <a href="{{ route('site.product', $p->id) }}">{{__('index.more_cta')}}</a>
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
    