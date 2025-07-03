<x-app-layout>
    <x-slot name="slot">
        <div class="">
            <h1 class="p-5">Створити товар</h1>
            <form class="max-w-7xl m-auto" enctype="multipart/form-data" action="{{ route('user.products.store') }}" method="post">
                @csrf
                @method('post')
                <div class="max-w-4xl mx-auto">
                    <label class="" >
                        <select name="sub_subcategory_id">
                            @foreach($subsubcategories as $s)
                                <option value="{{$s->id}}" {{ ($s->id != old('sub_subcategory_id')) ?: 'selected'}}>{{$s->title}}</option>
                            @endforeach
                        </select>
                    </label>
                    
                    <label class="flex flex-col justify-center mb-2">
                        Назва
                        <input class="" type="text" name="title" value="{{old('title')}}">
                        @error('title')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        Опис
                        <textarea name="description" value="{{ old('description')}}"></textarea>
                        @error('description')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="flex flex-col justify-center mb-2">
                            Валюта
                            <select name="currency_id">
                                @foreach($currency as $c)
                                    <option value="{{$c->id}}" {{ ($c->id != old('currency_id')) ?: 'selected'}}>{{$c->currency}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="flex flex-col justify-center mb-2">
                            Ціна
                            <input class="" type="text" name="price" value="{{ old('price') }}">
                            @error('price')
                                <span class="inline-block">{{ $message }}</span>
                            @enderror
                        </label>
                        <label class="flex flex-col justify-center mb-2">
                            Знижка
                            <input class="" type="number" step="1" name="discount" value="{{ old('discount') }}">
                            @error('discount')
                                <span class="inline-block">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    <label class="flex flex-col justify-center mb-2">
                        В наявності
                        <input class="" type="radio" name="availability" value="available" checked>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        Немає в наявності
                        <input type="radio" name="availability" value="not available" {{ ('not available' == old('availability')) ? 'checked' : ''}}>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <h3>Обрати колір:</h3>
                    <div class="grid grid-cols-3 items-center gap-2 mb-2">
                        @foreach($colors as $col)
                        <p class="flex gap-2 items-center">
                            <label for="colors">
                                <input type="checkbox" class="w-8 h-8" name="color_ids[]" style="background-color: {{ $col->hex}}" value="{{ $col->id }}">
                            </label>
                            <label>
                                <input type="file" class="file" name="img[{{ $col->id }}]">
                                <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#634FA2"><path d="M480-480ZM186.67-120q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h350v66.67h-350v586.66h586.66v-350H840v350q0 27-19.83 46.84Q800.33-120 773.33-120H186.67ZM240-281.33h480L574-476 449.33-311.33 356.67-434 240-281.33Zm448.67-322V-688h-85.34v-66.67h85.34V-840h66.66v85.33H840V-688h-84.67v84.67h-66.66Z"/></svg>
                            </label>
                        </p>
                        @endforeach
                        @error('color_ids')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <h3>Обрати розмір:</h3>
                    <div class="grid grid-cols-6 lg:grid-cols-12  gap-2 mb-3">
                        @foreach($sizes as $s)
                        <label class="block" for="colors">
                            <input type="checkbox" class="w-6 h-6" name="size_ids[]" value="{{ $s->id }}">{{ $s->name}}
                        </label>
                        @endforeach
                        @error('sizes_ids')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <button class="cta inline-block w-full mb-10 py-3 px-6 rounded-sm" type="submit">Створити</button>
                </div>
            </form>
        </div>
    </x-slot>
</x-app-layout>
    