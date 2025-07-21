<x-site-layout>
    <x-slot name="main">
        <main class="max-w-7xl mx-auto">
            <h1>{{__('catalogue.h1')}}</h1>
            <section>
                <div class="catalogue_container grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-5 mb-5">
                    @foreach ($catalogueProducts as $p)
                        <figure class="w-full {{$p->id}}">
                            <figcaption>
                                <picture><img src="{{ $p->getMedia('product')->isNotEmpty() ? $p->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $p->title }}"></picture>
                                <h3>{{$p->title}}</h3>
                                <p>{{__('catalogue.price')}}{{ number_format($p->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                                <form action="">
                                    @method('post')
                                    @csrf
                                    @if($p->colors->isNotEmpty())
                                        <p class="color">
                                            @foreach ($p->colors as $c)
                                                <label>
                                                    <input type="radio" name="color" style="background-color: {{ $c->hex}}" value="{{ $c->id }}">
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
    