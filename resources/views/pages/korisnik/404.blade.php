@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - 404</title>
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

        <div class="left_content">
            <div class="error_page">
                <h3>Žao nam je</h3>
                <h1>404</h1>
                <p>Strana koju ste tražili ne postoji u našem sistemu</p>
                <span></span> <a href="../index.html" class="wow fadeInLeftBig">Vrati se na početnu stranu</a> </div>
        </div>

    </div>


@endsection

@section('sidebar')
    @include('fixed.korisnik.najnovije')
@endsection

@section('footer')
    @include('fixed.korisnik.footer')
@endsection

@section('scripts')
    @include('fixed.korisnik.scripts')
@endsection