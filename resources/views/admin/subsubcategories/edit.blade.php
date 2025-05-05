<x-app-layout>
    <x-slot name="slot">
        <div class="text-[#fff]">
            <h1 class="text-3xl text-center p-5">Edit subsubcategory</h1>
            <form class="w-96 m-auto" action="{{ route('admin.subsubcategory.update', $subsubcategory->id) }}" method="post">
                @csrf
                @method('patch')
                <label class="flex flex-col justify-center mb-2">
                    Change subcategory
                    <select class="text-gray-800" name="subcategory_id">
                        @foreach ($subcategories as $sc)
                            <option class="text-gray-800" value="{{ $sc->id }}" {{ ($sc->id != old('subcategory_id', $subsubcategory->subcategory_id)) ?: 'selected'}}>
                                {{ $sc->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('subcategory_id')
                        <span>{{ $message }}</span>
                    @enderror
                </label>
                <label class="flex flex-col justify-center mb-2">
                    Change title
                    <input class="text-gray-800" type="text" name="title" value="{{ old('title',$subsubcategory->title) }}">
                    @error('title')
                        <span>{{ $message }}</span>
                    @enderror
                </label>
                <button class="text-[#fff] text-2xl inline-block w-full mb-10 py-3 px-6 duration-300 ease-in border border-white rounded-sm hover:bg-white hover:text-[#000]" type="submit">Submit</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
    