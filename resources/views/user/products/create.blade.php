<x-app-layout>
    <x-slot name="slot">
        <div class="text-[#fff]">
            <h1 class="text-3xl text-center p-5">Create product</h1>
            <form class="max-w-7xl m-auto" enctype="multipart/form-data" action="{{ route('user.products.store') }}" method="post">
                    @csrf
                    <label class="text-gray-800" >
                        <select name="sub_subcategory_id">
                            @foreach($subsubcategories as $s)
                                <option value="{{$s->id}}" {{ ($s->id != old('sub_subcategory_id')) ?: 'selected'}}>{{$s->title}}</option>
                            @endforeach
                        </select>
                    </label>
                    
                    <label class="flex flex-col justify-center mb-2">
                        Title
                        <input class="text-gray-800" type="text" name="title" value="{{old('title')}}">
                        @error('title')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        Description
                        <input class="text-gray-800" type="text" name="description" value="{{ old('description')}}">
                        @error('description')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        currency
                        <select name="currency_id">
                            @foreach($currency as $c)
                                <option value="{{$c->id}}" {{ ($c->id != old('currency_id')) ?: 'selected'}}>{{$c->currency}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        price
                        <input class="text-gray-800" type="text" name="price" value="{{ old('price') }}">
                        @error('price')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        discount
                        <input class="text-gray-800" type="number" step="1" name="discount" value="{{ old('discount') }}">
                        @error('discount')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        availability
                        <input class="text-gray-800" type="radio" name="availability" value="available" checked>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        not availability
                        <input class="text-gray-800" type="radio" name="availability" value="not available" {{ ('not available' == old('availability')) ? 'checked' : ''}}>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <h3>Add Colors:</h3>
                    <div class="grid grid-cols-6 lg:grid-cols-12 gap-2 mb-2">
                        @foreach($colors as $col)
                            <p>
                                <label for="colors">
                                    <input type="checkbox" class="w-8 h-8" name="color_ids[]" style="background-color: {{ $col->hex}}" value="{{ $col->id }}">
                                </label>
                                <label>
                                    <input type="file" name="img[{{ $col->id }}]">
                                </label>
                            </p>
                        @endforeach
                        @error('color_ids')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <h3>Add Sizes:</h3>
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
                    <button class="inline-block w-full mb-10 py-3 px-6 duration-300 ease-in border border-white rounded-sm hover:bg-white hover:text-[#000]" type="submit">Submit</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
    