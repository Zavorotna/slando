<x-app-layout>
    <x-slot name="slot">
        <div class="text-[#fff]">
            <h1 class="text-3xl text-center p-5">Edit product</h1>
            <form class="w-96 m-auto" action="{{ route('user.products.update', $product) }}" method="post">
                    @csrf
                    @method('patch')
                    <label class="text-gray-800" >
                        <select name="sub_subcategory_id">
                            @foreach($subsubcategories as $s)
                                <option value="{{$s->id}}" {{ ($s->id != old('sub_subcategory_id', $product->sub_subcategory_id)) ?: 'selected'}}>{{$s->title}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        Title
                        <input class="text-gray-800" type="text" name="title" value="{{old('title', $product->title)}}">
                        @error('title')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        Description
                        <input class="text-gray-800" type="text" name="description" value="{{ old('description', $product->description)}}">
                        @error('description')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        currency
                        <select name="currency_id">
                            @foreach($currency as $c)
                                <option value="{{$c->id}}" {{ ($c->id != old('currency_id', $product->currency_id)) ?: 'selected'}}>{{$c->currency}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        price
                        <input class="text-gray-800" type="text" name="price" value="{{ old('price', $product->price) }}">
                        @error('price')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        discount
                        <input class="text-gray-800" type="text" name="discount" value="{{ old('discount', $product->discount) }}">
                        @error('discount')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        availability
                        <input class="text-gray-800" type="radio" name="availability" value="available" {{ ('available' == old('availability', $product->availability)) ? 'checked' : ''}}>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        not availability
                        <input class="text-gray-800" type="radio" name="availability" value="not available" {{ ('not available' == old('availability', $product->availability)) ? 'checked' : ''}}>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>

                    <button class="inline-block w-full mb-10 py-3 px-6 duration-300 ease-in border border-white rounded-sm hover:bg-white hover:text-[#000]" type="submit">Submit</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
    