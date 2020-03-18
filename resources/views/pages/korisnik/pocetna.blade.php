@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - Početna</title>
    @include('fixed.korisnik.head')
@endsection

@section('header')
    @include('fixed.korisnik.header')
@endsection

@section('nav')
    @include('fixed.korisnik.nav')
@endsection

@section('center')


    <div class="slick_slider">

        @foreach($naslovna as $i)
            @component('partials.naslovna',['i'=>$i])
            @endcomponent
        @endforeach

    </div>

    <div class="left_content">

        @foreach($ostalo as $i)
            @component('partials.vest',['i'=>$i])
            @endcomponent
        @endforeach

    </div>

@endsection

@section('sidebar')

    @include('fixed.korisnik.najpopularnije')
    @include('fixed.korisnik.najnovije')

@endsection

@section('footer')
    @include('fixed.korisnik.footer')
@endsection

@section('scripts')
    @include('fixed.korisnik.scripts')
@endsection