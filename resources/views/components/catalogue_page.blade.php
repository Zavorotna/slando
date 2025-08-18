<div class="grid grid-rows-[1fr_1fr_1fr] grid-cols-2 md:grid-cols-4 gap-5 mb-5">
    @foreach ($catalogueProducts as $p)
        <figure class="product-card w-full {{$p->id}}">
            <figcaption>
                <picture><img class="product-main-image" src="{{ $p->getMedia('product')->isNotEmpty() ? $p->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $p->title }}"></picture>
                <h3>{{$p->title}}</h3>
                <p>{{__('catalogue.price')}}{{ number_format($p->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                <form class="add_to_cart" action="{{ route('site.cartAdd') }}" method="POST">
                    @csrf
                    @method('post')
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
                    <div class="flex gap-3 justify-between py-2">
                        @if($p->availability == 'available')
                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                            <button type="submit">{{__('index.cart_cta')}}</button>
                        @endif
                        <a href="{{ route('site.product', $p->id) }}">{{__('index.more_cta')}}</a>
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
</div>
<div class="pag_container">
    {{ $catalogueProducts->withQueryString()->onEachSide(2)->links('vendor.pagination.custom') }}
</div>