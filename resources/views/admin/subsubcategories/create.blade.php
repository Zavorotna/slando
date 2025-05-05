<x-app-layout>
    <x-slot name="slot">
        <div class="text-[#fff]">
            <h1 class="text-3xl text-center p-5">Create subsubcategory</h1>
            <form class="w-96 m-auto" action="{{ route('admin.subsubcategory.store') }}" method="post">
                @csrf
                <p>
                    <label class="flex flex-col justify-center mb-2">
                        Select subcategory
                        <select class="text-gray-800 w-full" name="subcategory_id">
                            @foreach ($subcategories as $sc)
                                <option class="text-gray-800" value="{{ $sc->id }}" 
                                    {{ ($sc->id == old('subcategory_id', $subsubcategory->subcategory_id)) 'selected'}}>
                                    {{ $sc->title }}</option>
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <span>{{ $message }}</span>
                        @enderror
                    </label>
                </p>
                <p class="mb-5">
                    <label class="flex flex-col justify-center mb-2">
                        Title
                        <input class="text-gray-800" type="text" name="title">
                        @error('title')
                            <span>{{ $message }}</span>
                        @enderror
                    </label>
                </p>
                <button class="inline-block w-full mb-10 py-3 px-6 duration-300 ease-in border border-white rounded-sm hover:bg-white hover:text-[#000]" type="submit">Submit</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
    