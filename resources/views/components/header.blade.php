
<div class="header_container">
    <div class="wrapper">
        <div class="logo">
            <a href="{{ route('site.index') }}">
                <img src="" alt="logo">
            </a>
        </div>
        <nav class="nav_container">
            <ul class="header_navigation">
                <li><a href="{{ route('site.index') }}">Головна</a></li>
                <li><a href="{{ route('site.catalogue') }}">Каталог</a></li>
            </ul>
        </nav>
        <div class="cart_container">
            <a href="{{ route('login') }}">Увійти</a>
            <a href="">Кошик</a>
        </div>
    </div>
</div>