<x-site-layout>
    <x-slot name="main">
        {{-- <script>
            const reviewStoreUrl = "{{ route('user.reviews.store') }}";
        </script> --}}
        <div class="max-w-7xl mx-auto card p-5 product-card">
            <div class="py-5 grid grid-cols-2 gap-5">
                <picture>
                    <img class="product-main-image object-cover w-full max-h-[500px]" src="{{ $product->getMedia('product')->isNotEmpty() ? $product->getFirstMediaUrl('product') : asset('/img/no-img.png') }}" alt="{{ $product->title }}">
                </picture>
                <div>
                    <h1 class="text-left mb-5">{{ $product->title }}</h1>
                    <p class="mb-2">{{ $product->description }}</p>
                    <p class="mb-2">{{$product->saleprice}} &#8372; <s>{{$product->price}} &#8372; </s></p>
                    @if($product->availability == 'available')
                        <p class="mb-2">{{__('product.available')}}</p>
                    @else
                        <p class="mb-2">{{__('product.notavailable')}}</p>
                    @endif
                    <p class="mb-2">{{__('product.seller')}}{{ $product->user->customer->name }}</p>
                    <form action="">
                        @method('post')
                        @if($product->colors->isNotEmpty())
                            <p class="color flex gap-2">
                                @foreach ($product->colors as $ind => $c)
                                        @php
                                        $colorPhotoUrls = $product->media->filter(function($img) use ($c) {
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
                        @if($product->sizes->isNotEmpty())
                            <p>
                                <select class="text-gray-800" name="sizes">
                                    @foreach ($product->sizes as $s)
                                        <option value="{{ $s->id }}">{{ $s->name}}</option>
                                    @endforeach
                                </select>
                            </p>
                        @endif
                        <div class="flex justify-between py-5">
                            @if($product->availability == 'available')
                                <button class="cta" type="submit">{{__('product.cart_cta')}}</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-5 border-black">
            <h2 class="mb-5">{{__('product.reviews_h2')}}</h2>
            <div class="grid grid-cols-2">
                <div class="all_reviews_block">
                    @if($reviews->isNotEmpty())
                        @foreach($reviews as $r)
                            <div class="review_block" data-id="{{ $r->id }}">
                                <p>{{ $r->user->customer->name }}</p>
                                <div>
                                    <div class="star star-review-block">
                                        <input type="hidden" class="rating" id="star" name="rating" value="{{ $r->rating }}">
                                        <div class="rate-stars flex gap-2 items-center">
                                            <div class="star-review" data-value="1"></div>
                                            <div class="star-review" data-value="2"></div>
                                            <div class="star-review" data-value="3"></div>
                                            <div class="star-review" data-value="4"></div>
                                            <div class="star-review" data-value="5"></div>
                                        </div>
                                    </div>
                                </div>
                                <p>{{ $r->comment }}</p>
                                @if(Auth::user())
                                    <div class="edit_form">
                                        <form class="d-none" method="post" action="{{ route('user.reviews.update', $r->id) }}">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div>
                                                <div class="star star-review-block ">
                                                    <input type="hidden" id="star" class="rating" name="rating" value="{{ $r->rating }}">
                                                    <div class="rate-stars flex gap-2 items-center">
                                                        <div class="star-review" data-value="1"></div>
                                                        <div class="star-review" data-value="2"></div>
                                                        <div class="star-review" data-value="3"></div>
                                                        <div class="star-review" data-value="4"></div>
                                                        <div class="star-review" data-value="5"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <textarea class="w-full text-gray-800" name="comment" required>{{ $r->comment }}</textarea>
                                            </div>
                                            <button class="submit_edit" type="submit">{{__('product.edit_cta')}}</button>
                                        </form>
                                        @if ($r->user_id === Auth::id())
                                            <a class="edit_button" href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="gray"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg></a>
                                        @endif
                                    </div>
                                    @if ($r->user_id === Auth::id())
                                        <form class="delete_form" method="post" action="{{ route('user.reviews.destroy', $r->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button id="delete_review" class="delete_review" data-id="{{ $r->id }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#992B15"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                        {{ $reviews->withQueryString()->onEachSide(2)->links('vendor.pagination.custom') }}
                    @else
                        <p class="no-reviews">{{__('product.no_reviews')}}</p>
                    @endif
                </div>
                <div>
                    @if(Auth::user())
                        <h2>{{__('product.add_reviews')}}</h2>
                        <form class="p-5 reviews_container" method="post" action="{{ route('user.reviews.store') }}">
                            @csrf
                            @method('post')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div>
                                <div class="star star-review-block ">
                                    <input type="hidden" id="star" name="rating" value="">
                                    <div class="rate-stars flex gap-2 items-center">
                                        <div class="star-review" data-value="1"></div>
                                        <div class="star-review" data-value="2"></div>
                                        <div class="star-review" data-value="3"></div>
                                        <div class="star-review" data-value="4"></div>
                                        <div class="star-review" data-value="5"></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <textarea class="w-full text-gray-800" name="comment" required></textarea>
                            </div>
                            <button class="cta" id="reviewCta" type="submit">{{__('product.add_reviews_cta')}}</button>
                        </form>
                    @else
                        <p>{{__('product.logit_to_add_reviews')}}<a href="{{ route('login') }}">{{__('product.logit_to_add_reviews_1')}}</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
</x-site-layout>
    