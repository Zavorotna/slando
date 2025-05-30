<x-app-layout>
    <x-slot name="slot">
        <div class="text-[#fff]">
            <h1 class="text-3xl text-center p-5">Edit size</h1>
            <form class="w-96 m-auto" action="{{ route('admin.size.update', $size->id) }}" method="post">
                @csrf
                @method('patch')
                <label class="flex flex-col justify-center mb-2">
                    Change name
                    <input class="text-gray-800" type="text" name="name" value="{{ old('name', $size->name) }}">
                    @error('name')
                        <span>{{ $message }}</span>
                    @enderror
                </label>
                <button class="text-[#fff] text-2xl inline-block w-full mb-10 py-3 px-6 duration-300 ease-in border border-white rounded-sm hover:bg-white hover:text-[#000]" type="submit">Submit</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
    