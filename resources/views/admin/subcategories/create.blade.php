<x-app-layout>
    <x-slot name="slot">
        <div class="text-[#fff]">
            <h1 class="text-3xl text-center p-5">Create subcategory</h1>
            <form class="w-96 m-auto" action="{{ route('admin.subcategory.store') }}" method="post">
                @csrf
                <p>
                    <label class="flex flex-col justify-center mb-2">
                        Select category
                        <select class="text-gray-800" name="category_id">
                            @foreach ($categories as $c)
                                <option class="text-gray-800" value="{{ $c->id }}"
                                    {{ ($c->id == old('category_id', $subcategory->category_id)) 'selected'}}>{{ $c->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span>{{ $message }}</span>
                        @enderror
                    </label>
                </p>
                <p>
                    <label class="flex flex-col justify-center mb-2">
                        Title
                        <input class="text-gray-800" type="text" name="title" value="{{ old('title') }}">
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
    