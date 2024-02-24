@extends('layouts.app')

@section('app-content')

    @if (Route::is('about'))
        @include('partials.about.about')
    @endif

    @if (Route::is('about.entity'))
        @include('partials.about.' . $entity)
    @endif

@endsection
