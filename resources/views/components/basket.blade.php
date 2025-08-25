<div>
    @forelse ($cartItems as $item)
        <div class="cart_block relative grid grid-cols-[1fr_3fr_1fr_1fr] items-center border gap-2 mb-2 p-2">
            <a href="{{ route('site.product', $item->attributes->product_id) }}">
                <picture>
                    <img src="{{  $item->attributes->img_url ?: asset('/img/no-img.png') }}" alt="">
                </picture>
            </a>
            <div>
                <h2 class="text-lg text-left p-0">{{ $item->name }}</h2>
                <p class="flex gap-2"><span style="background-color: {{$item->attributes->color_hex}}; display: block; width: 20px; height:20px;"></span> {{$item->attributes->color_name}}</p>
                <p>Розмір: {{$item->attributes->size}}</p>
            </div>
            <form class="flex justify-center items-center quantity_form" action="{{ route('site.updateCart') }}" method="post">
                @csrf
                <button type="submit" name='action_btn' value="-" class="min">-</button>
                <input class="max-w-24" type="number" min="1" step="1" name="quantity" value="{{$item->quantity}}">
                <input type="hidden" name="id" value="{{$item->id}}">
                <button type="submit" name="action_btn" value="+" class="plus">+</button>
            </form>
            <p class="text-right">{{$item->price}}</p>
            <form class="delete_btn" action="{{ route('site.deleteItem', $item->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit">видалити</button>
            </form>
        </div>
    @empty
        <p>Кошик порожній</p>
    @endforelse
</div>
<div class="cart_product_container">
    <p>Знижка: {{$cartItems->total_discount}}</p>
    <p>Сума до оплати: {{$cartItems->total_price}}</p>
    <span style="display: none" class="count">{{Cart::getTotalQuantity()}}</span>
    <div>
        <a href="{{route('site.orderCreate')}}">Оформити замовлення</a>
        <a href="{{route('site.catalogue')}}">Назад у каталог</a>
    </div>
</div>