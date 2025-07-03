<x-app-layout>
    <x-slot name="slot">
        <div class="">
            <h1 class="text-3xl text-center p-5">Edit product</h1>
            <form class="w-96 m-auto" enctype="multipart/form-data"  action="{{ route('user.products.update', $product) }}" method="post">
                    @csrf
                    @method('patch')
                    <label class="" >
                        <select name="sub_subcategory_id">
                            @foreach($subsubcategories as $s)
                                <option value="{{$s->id}}" {{ ($s->id != old('sub_subcategory_id', $product->sub_subcategory_id)) ?: 'selected'}}>{{$s->title}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        Title
                        <input class="" type="text" name="title" value="{{old('title', $product->title)}}">
                        @error('title')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        Description
                        <input class="" type="text" name="description" value="{{ old('description', $product->description)}}">
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
                        <input class="" type="text" name="price" value="{{ old('price', $product->price) }}">
                        @error('price')
                            <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        discount
                        <input class="" type="text" name="discount" value="{{ old('discount', $product->discount) }}">
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
                                    <input type="file" class="file" name="img[{{ $col->id }}]">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#634FA2"><path d="M480-480ZM186.67-120q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h350v66.67h-350v586.66h586.66v-350H840v350q0 27-19.83 46.84Q800.33-120 773.33-120H186.67ZM240-281.33h480L574-476 449.33-311.33 356.67-434 240-281.33Zm448.67-322V-688h-85.34v-66.67h85.34V-840h66.66v85.33H840V-688h-84.67v84.67h-66.66Z"/></svg>

                                </label>
                                @error('img.*')
                                    <span class="inline-block">{{ $message }}</span>
                                @enderror
                                @if(isset($images[$col->id]))
                                    <picture>
                                        <img src="{{ $images[$col->id]->getUrl() }}" alt="Колір {{ $col->name }}">
                                    </picture>
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
                        <input class="" type="radio" name="availability" value="available" {{ ('available' == old('availability', $product->availability)) ? 'checked' : ''}}>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>
                    <label class="flex flex-col justify-center mb-2">
                        not availability
                        <input class="" type="radio" name="availability" value="not available" {{ ('not available' == old('availability', $product->availability)) ? 'checked' : ''}}>
                        @error('availability')
                        <span class="inline-block">{{ $message }}</span>
                        @enderror
                    </label>

                    <button class="cta inline-block w-full mb-10 py-3 px-6 rounded-sm" type="submit">Submit</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
    