<x-site-layout>
    <x-slot name="main">
       <form action="{{ route('admin.category.store') }}" method="post">
            @csrf
            <label>
                Create category
                <input class="text-gray-800" type="text" name="title">
            </label>
            <button type="submit">Submit</button>
       </form>
    </x-slot>
</x-site-layout>
    