@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - {{ $tag->nazivTag }}</title>
    @include('fixed.korisnik.head')
@endsection

@section('header')
    @include('fixed.korisnik.header')
@endsection

@section('nav')
    @include('fixed.korisnik.nav')
@endsection

@section('center')

    <div class="left_content">
        <p class="linija">{{ $tag->nazivTag }}</p>

        @foreach($vesti as $i)
            @component('partials.vest',['i'=>$i])
            @endcomponent
        @endforeach

    </div>

    <div class="row">
        {{ $vesti->links() }}
    </div>

@endsection

@section('sidebar')
    @include('fixed.korisnik.najnovije')
    @include('fixed.korisnik.najpopularnije')
@endsection

@section('footer')
    @include('fixed.korisnik.footer')
@endsection

@section('scripts')
    @include('fixed.korisnik.scripts')
@endsection