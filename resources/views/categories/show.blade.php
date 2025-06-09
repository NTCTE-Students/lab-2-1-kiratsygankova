@extends('layouts.app')

   @section('title', $category->name)

   @section('content')
       <h1 class="text-2xl font-bold mb-4">{{ $category->name }}</h1>
       <p class="text-gray-600 mb-4">{{ $category->description }}</p>
       <h2 class="text-xl font-semibold mb-2">Статьи в категории</h2>
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
           @foreach ($category->articles as $article)
               <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
                   <h2 class="text-xl font-semibold">{{ $article->title }}</h2>
                   <p class="text-gray-600">{{ Str::limit($article->content, 100) }}</p>
                   <a href="{{ route('articles.show', $article) }}" class="text-blue-500 hover:underline">Читать далее</a>
               </div>
           @endforeach
       </div>
       @auth
           @if (Auth::user()->is_admin)
               <div class="mt-4 flex space-x-2">
                   <a href="{{ route('categories.edit', $category) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Редактировать</a>
                   <form action="{{ route('categories.destroy', $category) }}" method="POST">
                       @csrf
                       @method('DELETE')
                       <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Вы уверены?')">Удалить</button>
                   </form>
               </div>
           @endif
       @endauth
   @endsection