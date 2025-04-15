<x-site-layout>
    <x-slot name="main">
       <form action="{{ route('admin.category.update', $category->id) }}" method="post">
            @csrf
            @method('patch')
            <label>
                Edit category
                <input class="text-gray-800" type="text" name="title" value="{{ $category->title }}">
            </label>
            <button type="submit">Submit</button>
       </form>
    </x-slot>
</x-site-layout>
    