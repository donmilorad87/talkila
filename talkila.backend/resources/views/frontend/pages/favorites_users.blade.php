@extends('frontend.layouts.frontendlayout')
@section('content')
    <div class="container">

        @include('frontend.partials.pages.favorites.favorites-users', compact('userFavoritesData'))

    </div>
@endsection
