<x-site-layout>
    <x-slot name="main">
       <form action="{{ route('site.orderStore') }}" method="POST">
            @csrf
            <div>
                <p>
                    <label>
                        Ім'я
                        <input type="text" name="name" value="{{ Auth::user() ? Auth::user()->customer->name : ''}}">
                    </label>
                </p>
                <p>
                    <label>
                        Прізвище
                        <input type="text" name="surname" value="{{ Auth::user() ? Auth::user()->customer->surname : ''}}">
                    </label>
                </p>
            </div>
            <div>
                <p>
                    <label>
                        Телефон
                        <input type="tel" name="phone" value="{{ Auth::user() ? Auth::user()->customer->phone : ''}}">
                    </label>
                </p>
                <p>
                    <label>
                        Адреса
                        <input type="text" name="adress">
                    </label>
                </p>
            </div>
            <button type="submit">Замовити</button>
       </form>
    </x-slot>
</x-site-layout>
    