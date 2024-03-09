@extends('layouts.app')

@section('app-content')

    @if (Route::is('home'))
        @include('partials.home.home')
    @endif

    @if (Route::is('home.entity'))
        @include('partials.home.' . $entity)
    @endif

@endsection
