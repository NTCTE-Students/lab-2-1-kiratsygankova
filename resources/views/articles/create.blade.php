@extends('layouts.app')

   @section('title', 'Создать статью')

   @section('content')
       <h1 class="text-2xl font-bold mb-4">Создать статью</h1>
       <form action="{{ route('articles.store') }}" method="POST" class="space-y-4">
           @csrf
           <div>
               <label for="title" class="block text-sm font-medium">Заголовок</label>
               <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full p-2 border rounded @error('title') border-red-500 @enderror" required>
               @error('title')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <div>
               <label for="content" class="block text-sm font-medium">Содержимое</label>
               <textarea name="content" id="content" class="w-full p-2 border rounded @error('content') border-red-500 @enderror" rows="6" required>{{ old('content') }}</textarea>
               @error('content')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <div>
               <label for="categories" class="block text-sm font-medium">Категории</label>
               <select name="categories[]" id="categories" multiple class="w-full p-2 border rounded @error('categories') border-red-500 @enderror">
                   @forelse ($categories as $category)
                       <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                   @empty
                       <option disabled>Нет доступных категорий</option>
                   @endforelse
               </select>
               @error('categories')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Создать</button>
       </form>
   @endsection