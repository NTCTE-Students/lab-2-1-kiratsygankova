@extends('layouts.app')

   @section('title', $article->title)

   @section('content')
       <h1 class="text-2xl font-bold mb-4">{{ $article->title }}</h1>
       <p class="text-gray-600 mb-2">Автор: {{ $article->user->name }}</p>
       <p class="text-gray-600 mb-2">Категории: {{ $article->categories->pluck('name')->join(', ') }}</p>
       <p class="text-gray-600 mb-4">Опубликовано: {{ $article->created_at->format('d.m.Y H:i') }}</p>
       <p class="prose max-w-none">{{ $article->content }}</p>
       @auth
           @if (Auth::id() == $article->user_id || Auth::user()->is_admin)
               <div class="mt-4 flex space-x-2">
                   <a href="{{ route('articles.edit', $article) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Редактировать</a>
                   <form action="{{ route('articles.destroy', $article) }}" method="POST">
                       @csrf
                       @method('DELETE')
                       <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Вы уверены?')">Удалить</button>
                   </form>
               </div>
           @endif
       @endauth
   @endsection