@extends('layouts.app')

   @section('title', 'Создать категорию')

   @section('content')
       <h1>Создать категорию</h1>
       <form action="{{ route('categories.store') }}" method="POST">
           @csrf
           <div>
               <label for="name">Название</label>
               <input type="text" name="name" id="name" value="{{ old('name') }}" class="{{ $errors->has('name') ? 'error' : '' }}" required>
               @error('name')
                   <p style="color: red; font-size: 0.9em;">{{ $message }}</p>
               @enderror
           </div>
           <div>
               <label for="description">Описание</label>
               <textarea name="description" id="description" class="{{ $errors->has('description') ? 'error' : '' }}" rows="4">{{ old('description') }}</textarea>
               @error('description')
                   <p style="color: red; font-size: 0.9em;">{{ $message }}</p>
               @enderror
           </div>
           <button type="submit">Создать</button>
       </form>
   @endsection