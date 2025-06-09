@extends('layouts.app')

   @section('title', 'Список статей')

   @section('content')
       <div class="flex justify-between mb-4">
           <h1 class="text-2xl font-bold">Статьи</h1>
           @auth
               <a href="{{ route('articles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Создать статью</a>
           @endauth
       </div>

       <div class="flex gap-4 mb-4">
           <form action="{{ route('articles.index') }}" method="GET" class="flex-1">
               <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по заголовку или содержимому" class="w-full p-2 border rounded">
           </form>
           <form action="{{ route('articles.index') }}" method="GET">
               <select name="category" onchange="this.form.submit()" class="p-2 border rounded">
                   <option value="">Все категории</option>
                   @forelse ($categories as $category)
                       <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                   @empty
                       <option disabled>Нет доступных категорий</option>
                   @endforelse
               </select>
           </form>
       </div>

       <div class="space-y-4">
           @forelse ($articles as $article)
               <div class="card p-4 border rounded">
                   <h2 class="text-xl font-semibold">{{ $article->title }}</h2>
                   <p>{{ Str::limit($article->content, 100) }}</p>
                   <p class="text-sm text-gray-600">Автор: {{ $article->user->name }}</p>
                   <p class="text-sm text-gray-600">Категории: {{ $article->categories->pluck('name')->join(', ') }}</p>
                   <a href="{{ route('articles.show', $article) }}" class="text-blue-500 hover:underline">Читать далее</a>
               </div>
           @empty
               <p>Статьи не найдены.</p>
           @endforelse
       </div>

       <div class="pagination mt-4">
           {{ $articles->appends(request()->query())->links() }}
       </div>
   @endsection