<x-app-layout>
    <x-slot name="slot">
        <div class="text-[#fff]">
            <h1 class="text-3xl text-center p-5">Edit product</h1>
            <form class="w-96 m-auto" enctype="multipart/form-data"  action="{{ route('user.products.update', $product) }}" method="post">
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
                    <div>
                        <h2>Add Colors:</h2>
                        @foreach($colors as $col)
                            <p class="grid grid-cols-3 items-center gap-2">
                                <label>
                                    <input type="checkbox" class="w-8 h-8" name="color_ids[]"
                                    {{ (in_array($col->id, $productColors) && !old('color_ids') || is_array(old('color_ids')) && in_array($col->id, old('color_ids'))) ? 'checked' : '' }}
                                    style="background-color: {{ $col->hex}}" value="{{ $col->id }}">
                                </label>
                                <label>
                                    <input type="file" name="img[{{ $col->id }}]">
                                </label>
                                @error('img.*')
                                    <span class="inline-block">{{ $message }}</span>
                                @enderror
                                @if(isset($images[$col->id]))
                                    <picture>
                                        <img src="{{ $images[$col->id]->getUrl() }}" alt="Колір {{ $col->name }}">
                                    </picture>
                                    {{-- <input type="checkbox" name="deleteImg[]" value="{{ $images[$col->id]->id }}"> --}}
                                @endif

                            </p>
                            
                        @endforeach
                        @error('color_ids')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                       
                    </div>
                    <h3>Add Sizes:</h3>
                    <div class="grid grid-cols-6 lg:grid-cols-12  gap-2 mb-3">
                        @foreach($sizes as $s)
                            <label class="block">
                                <input type="checkbox" class="w-6 h-6" name="size_ids[]" 
                                    {{ (in_array($s->id, $productSizes) && !old('size_ids') || is_array(old('size_ids')) && in_array($s->id, old('size_ids'))) ? 'checked' : '' }} 
                                    value="{{ $s->id }}">{{ $s->name}}
                            </label>
                        @endforeach
                        @error('size_ids')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </div>
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
    