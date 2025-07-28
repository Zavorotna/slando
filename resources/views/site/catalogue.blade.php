<x-site-layout>
    <x-slot name="main">
        <main class="max-w-7xl mx-auto">
            <h1>{{__('catalogue.h1')}}</h1>
            <section class="grid grid-cols-[20%_80%] gap-3">
                <form class="filter" action="{{ route('site.catalogue') }}">
                    
                    <h2>{{__('catalogue.Фільтр')}}</h2>
                    <div>
                        <select name="sub_subcategory_id">
                            @foreach($subsubcategories as $s)
                                <option value="{{$s->id}}">{{$s->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <div class="slider">
                            <div class="range" id="range"></div>
                            <div class="values">
                                <span id="min-value" data-price="{{$priceMin}}"></span><br>
                                <span id="max-value" data-price="{{$priceMax}}"></span>
                            </div>
                            <div class="handle" id="min-handle"></div>
                            <div class="handle" id="max-handle"></div>
                        </div>
                        <input type="hidden" id="min-price" name="min_price">
                        <input type="hidden" id="max-price" name="max_price">
                    </div>
                    <div class="color_container">
                        @foreach ($colors as $col)
                            <label><input type="checkbox" class="{{ strtolower($col->hex) === '#ffffff' ? 'accent-black' : '' }}" name="colors[]" value="{{$col->id}}" style="background-color: {{$col->hex}}"></label>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-3">
                        @foreach ($sizes as $siz)
                            <label class="sizes">
                                <input type="checkbox" name="sizes[]" value="{{$siz->id}}">
                                <span>{{$siz->name}}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit">{{__('catalogue.Застосувати')}}</button>
                    <button type="reset">{{__('catalogue.Скинути')}}</button>
                </form>
                <div class="catalogue_container grid grid-rows-[1fr_1fr_1fr] grid-cols-2 md:grid-cols-4 gap-5 mb-5">
                    @foreach ($catalogueProducts as $p)
                        <figure class="product-card w-full {{$p->id}}">
                            <figcaption>
                                <picture><img class="product-main-image" src="{{ $p->getMedia('product')->isNotEmpty() ? $p->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $p->title }}"></picture>
                                <h3>{{$p->title}}</h3>
                                <p>{{__('catalogue.price')}}{{ number_format($p->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                <form action="">
                                    @method('post')
                                    @csrf
                                    @if($p->colors->isNotEmpty())
                                        <p class="color flex gap-2">
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
                                            <button type="submit">{{__('catalogue.cart_cta')}}</button>
                                        @endif
                                        <a href="{{ route('site.product', $p->id) }}">{{__('catalogue.about_cta')}}</a>
                                    </div>
                                </form>
                                @if(Auth::check())
                                    @if($user && $user->likedProducts->contains($p))
                                        <form action="{{ route('site.removeLiked') }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $p->id }}">
                                            <button type="submit">{{__('catalogue.unlike_cta')}}</button>
                                        </form>
                                    @else 
                                        <form action="{{ route('site.liked') }}" method="post">
                                            @csrf
                                            @method('post')
                                            <input type="hidden" name="id" value="{{ $p->id }}">
                                            <button type="submit">{{__('catalogue.like_cta')}}</button>
                                        </form>
                                    @endif
                                @endif
                            </figcaption>
                        </figure>
                    @endforeach
                    <div class="pag_container">
                        {{ $catalogueProducts->withQueryString()->onEachSide(2)->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </section>
        </main>

    </x-slot>
</x-site-layout>
    