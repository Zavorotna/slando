<x-site-layout>
    <x-slot name="main">
        <div class="max-w-7xl mx-auto">
            <div class="py-5 grid grid-cols-2">
                <picture>
                    <img src="{{ $product->getMedia('product')->isNotEmpty() ? $product->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $product->title }}">
                </picture>
                <div>
                    <h1 class="text-xl mb-5">{{ $product->title }}</h1>
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
                </div>
            </div>
            <hr class="my-5">
            <h2 class="text-center text-xl mb-5">Відгуки про товар</h2>
            <div class="grid grid-cols-2 gap-5">
                @if($product->reviews->isNotEmpty())
                    <div>
                        @foreach($product->reviews as $r)
                            <p>User name: {{ $r->user->customer->name }}</p>
                            <p>Rating {{ $r->rating }}</p>
                            <p>Comment: {{ $r->comment }}</p>
                            @if(Auth::user())
                                <form  method="post" action="{{ route('user.reviews.update', $r->id) }}">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div>
                                        <p>Оцінка:</p>
                                        <input class="w-full text-gray-800" type="number" name="rating" value="{{ $r->rating }}" min="1" max="5" required>
                                    </div>
                                    <div>
                                        <p>Коментар:</p>
                                        <textarea class="w-full text-gray-800" name="comment" required>{{ $r->comment }}</textarea>
                                    </div>
                                    <button type="submit">Оновити</button>
                                </form>
                                <form method="post" action="{{ route('user.reviews.destroy', $r->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit">Видалити</button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                @endif
                <div>
                    @if(Auth::user())
                        <h2>Залишити відгук</h2>
                        <form method="post" action="{{ route('user.reviews.store') }}">
                            @csrf
                            @method('post')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div>
                                <p>Оцінка:</p>
                                <label><input class="w-full text-gray-800" type="number" name="rating" min="1" max="5" required></label>
                            </div>
                            <div>
                                <p>Коментар:</p>
                                <textarea class="w-full text-gray-800" name="comment" required></textarea>
                            </div>
                            <button type="submit">Надіслати</button>
                        </form>
                    @else
                        <p>Щоб залишити відгук, <a href="{{ route('login') }}">увійдіть</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
</x-site-layout>
    