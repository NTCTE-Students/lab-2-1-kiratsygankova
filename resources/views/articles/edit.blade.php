@extends('layouts.app')

   @section('title', 'Редактировать статью')

   @section('content')
       <h1 class="text-2xl font-bold mb-4">Редактировать статью</h1>
       <form action="{{ route('articles.update', $article) }}" method="POST" class="space-y-4">
           @csrf
           @method('PUT')
           <div>
               <label for="title" class="block text-sm font-medium">Заголовок</label>
               <input type="text" name="title" id="title" value="{{ $article->title }}" class="w-full p-2 border rounded @error('title') border-red-500 @enderror" required>
               @error('title')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <div>
               <label for="content" class="block text-sm font-medium">Содержимое</label>
               <textarea name="content" id="content" class="w-full p-2 border rounded @error('content') border-red-500 @enderror" rows="6" required>{{ $article->content }}</textarea>
               @error('content')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <div>
               <label for="categories" class="block text-sm font-medium">Категории</label>
               <select name="categories[]" id="categories" multiple class="w-full p-2 border rounded @error('categories') border-red-500 @enderror">
                   @foreach ($categories as $category)
                       <option value="{{ $category->id }}" {{ $article->categories->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                   @endforeach
               </select>
               @error('categories')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Сохранить</button>
       </form>
   @endsection
