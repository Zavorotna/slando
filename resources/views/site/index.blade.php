<x-site-layout>
    <x-slot name="main">
        <main class="main_page">
            <div class="main_container">
                <div class="max-w-3xl mx-auto">
                    <h1>{{__('index.h1')}}</h1>
                    <p>{{__('index.descr_main')}}</p>
                </div>
            </div>
            <div class="py-5 max-w-7xl mx-auto">
                <section>
                    <h2>{{__('index.popular_h2')}}</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                        @foreach ($popularProducts as $popularProduct)
                            <figure class="product-card {{ $popularProduct->id }}">
                                <figcaption>
                                    <picture><img class="product-main-image" src="{{ $popularProduct->getMedia('product')->isNotEmpty() ? $popularProduct->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $popularProduct->title }}"></picture>
                                    <h3>{{$popularProduct->title}}</h3>
                                    <p>{{ number_format($popularProduct->saleprice, 0, ',', ' ')}}&nbsp;&#8372;</p>
                                    <form action="{{ route('site.cartAdd') }}" method="POST">
                                        @csrf
                                        @method('post')
                                        @if($popularProduct->colors->isNotEmpty())
                                            <p class="color flex gap-2">
                                                @foreach ($popularProduct->colors as $ind => $c)
                                                        @php
                                                        $colorPhotoUrls = $popularProduct->media->filter(function($img) use ($c) {
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
                                                <input type="hidden" name="product_id" value="{{ $popularProduct->id }}">
                                                <button type="submit">{{__('index.cart_cta')}}</button>
                                            @endif
                                            <a href="{{ route('site.product', $popularProduct->id) }}">{{__('index.more_cta')}}</a>
                                        </div>
                                    </form>
                                    @if(Auth::check())
                                        @if($user && $user->likedProducts->contains($popularProduct))
                                            <form action="{{ route('site.removeLiked') }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $popularProduct->id }}">
                                                <button type="submit">{{__('index.unlike')}}</button>
                                            </form>
                                        @else 
                                            <form action="{{ route('site.liked') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $popularProduct->id }}">
                                                <button type="submit">{{__('index.liked')}}</button>
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
                            <h2>{{__('index.new_h2')}}</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5">
                                @foreach ($newProducts as $newProduct)
                                <figure class="product-card w-full {{$newProduct->id}}">
                                    <figcaption>
                                        <picture><img class="product-main-image" src="{{ $newProduct->getMedia('product')->isNotEmpty() ? $newProduct->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $newProduct->title }}"></picture>
                                        <h3>{{$newProduct->title}}</h3>
                                        <p>{{ number_format($newProduct->saleprice, 0, ',', ' ')}}&nbsp;&#8372;</p>
                                        <form action="{{ route('site.cartAdd') }}" method="POST">
                                            @csrf
                                            @method('post')
                                            @if($newProduct->colors->isNotEmpty())
                                            <p class="color flex gap-2">
                                                @foreach ($newProduct->colors as $ind => $c)
                                                     @php
                                                        $colorPhotoUrls = $newProduct->media->filter(function($img) use ($c) {
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
                                                    <input type="hidden" name="product_id" value="{{ $newProduct->id }}">
                                                    <button type="submit">{{__('index.cart_cta')}}</button>
                                                @endif
                                                <a href="{{ route('site.product', $newProduct->id) }}">{{__('index.more_cta')}}</a>
                                            </div>
                                        </form>
                                        @if(Auth::check())
                                            @if($user && $user->likedProducts->contains($newProduct))
                                                <form action="{{ route('site.removeLiked') }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $newProduct->id }}">
                                                    <button type="submit">{{__('index.unlike')}}</button>
                                                </form>
                                            @else 
                                                <form action="{{ route('site.liked') }}" method="post">
                                                    @csrf
                                                    @method('post')
                                                    <input type="hidden" name="id" value="{{ $newProduct->id }}">
                                                    <button type="submit">{{__('index.liked')}}</button>
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
    