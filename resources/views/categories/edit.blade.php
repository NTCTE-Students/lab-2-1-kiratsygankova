@extends('layouts.app')

   @section('title', 'Редактировать категорию')

   @section('content')
       <h1 class="text-2xl font-bold mb-4">Редактировать категорию</h1>
       <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
           @csrf
           @method('PUT')
           <div>
               <label for="name" class="block text-sm font-medium">Название</label>
               <input type="text" name="name" id="name" value="{{ $category->name }}" class="w-full p-2 border rounded @error('name') border-red-500 @enderror" required>
               @error('name')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <div>
               <label for="description" class="block text-sm font-medium">Описание</label>
               <textarea name="description" id="description" class="w-full p-2 border rounded @error('description') border-red-500 @enderror" rows="4">{{ $category->description }}</textarea>
               @error('description')
                   <p class="text-red-500 text-sm">{{ $message }}</p>
               @enderror
           </div>
           <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Сохранить</button>
       </form>
   @endsection