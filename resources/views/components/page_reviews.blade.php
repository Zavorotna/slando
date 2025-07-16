@if($reviews->isNotEmpty())
    @foreach($reviews as $r)
        <div class="review_block" data-id="{{ $r->id }}">
            <p>User name: {{ $r->user->customer->name }}</p>
            <div>
                <p>Оцінка:</p>
                <div class="star star-review-block ">
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
            <p>Comment: {{ $r->comment }}</p>
            @if(Auth::user())
                <div class="edit_form">
                    <form class="d-none" method="post" action="{{ route('user.reviews.update', $r->id) }}">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div>
                            <p>Оцінка:</p>
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
                            <p>Коментар:</p>
                            <textarea class="w-full text-gray-800" name="comment" required>{{ $r->comment }}</textarea>
                        </div>
                        <button class="submit_edit" type="submit">Оновити відгук</button>
                    </form>
                    <a class="edit_button" href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg></a>
                </div>
                <form class="delete_form" method="post" action="{{ route('user.reviews.destroy', $r->id) }}">
                    @csrf
                    @method('delete')
                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#992B15"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                </form>
            @endif
        </div>
    @endforeach
    {{ $reviews->withQueryString()->onEachSide(2)->links('vendor.pagination.custom') }}
@else
    <p>В цього товару поки що немає відгуків</p>
@endif