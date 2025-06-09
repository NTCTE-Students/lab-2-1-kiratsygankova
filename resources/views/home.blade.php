@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="container">
        <h1>Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <p>Перейдите к <a href="{{ route('articles.index') }}">списку статей</a> или <a href="{{ route('categories.index') }}">категориям</a>.</p>
    </div>
@endsection