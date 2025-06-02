<x-site-layout>
    <x-slot name="main">
        <h1>Slando</h1> 
        <section>
            <h2>Популярні товари</h2>
            <div class="grid grid-cols-4 gap-5">
                @foreach ($popularProducts as $popularProduct)
                    <figure>
                        <figcaption>
                            <a href=""></a>
                            <img src="" alt="{{ $popularProduct->title }}">
                            <h3>{{$popularProduct->title}}</h3>
                            <p>Ціна: {{ number_format($popularProduct->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                            <a href="{{ route('site.product', $popularProduct->id) }}">Детальніше</a>
                        </figcaption>
                    </figure>
                    @endforeach
                </div>
            </section>
            <section>
                <h2>Новинки</h2>
                <div class="grid grid-cols-4 gap-5">
                    @foreach ($newProducts as $newProduct)
                    <figure>
                        <figcaption>
                            <a href=""></a>
                            <img src="" alt="{{ $newProduct->title }}">
                            <h3>{{$newProduct->title}}</h3>
                            <p>Ціна: {{ number_format($newProduct->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                            <a href="{{ route('site.product', $newProduct->id) }}">Детальніше</a>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>

    </x-slot>
</x-site-layout>
    