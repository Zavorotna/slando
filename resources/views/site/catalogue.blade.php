<x-site-layout>
    <x-slot name="main">
        <h1>Каталог</h1> 
        <section>
            <div class="grid grid-cols-4 gap-5">
                @foreach ($catalogueProducts as $p)
                    <figure>
                        <figcaption>
                            <a href=""></a>
                            <img src="" alt="{{ $p->title }}">
                            <h3>{{$p->title}}</h3>
                            <p>Ціна: {{ number_format($p->saleprice, 1, ',', ' ')}}&nbsp;&#8372;</p>
                            <a href="{{ route('site.product', $p->id) }}">Детальніше</a>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>

    </x-slot>
</x-site-layout>
    