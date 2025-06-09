@extends('layouts.app')

   @section('title', 'Категории')

   @section('content')
       <h1>Категории</h1>
       @auth
           @if (Auth::user()->is_admin)
               <a href="{{ route('categories.create') }}">Создать категорию</a>
           @endif
       @endauth
       @if (session('success'))
           <div class="alert alert-success">{{ session('success') }}</div>
       @endif
       @foreach ($categories as $category)
           <div class="card">
               <h2>{{ $category->name }}</h2>
               <p>{{ $category->description }}</p>
               <a href="{{ route('categories.show', $category) }}">Просмотреть</a>
               @auth
                   @if (Auth::user()->is_admin)
                       <a href="{{ route('categories.edit', $category) }}">Редактировать</a>
                       <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                           @csrf
                           @method('DELETE')
                           <button type="submit">Удалить</button>
                       </form>
                   @endif
               @endauth
           </div>
       @endforeach
       {{ $categories->links() }}
   @endsection