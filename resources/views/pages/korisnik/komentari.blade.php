@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - Komentari</title>
    @include('fixed.korisnik.head')
@endsection

@section('header')
    @include('fixed.korisnik.header')
@endsection

@section('nav')
    @include('fixed.korisnik.nav')
@endsection

@section('center')

    <div id="centar">

        <h1>{{ $naslov }}</h1>

        <div class="row  bootstrap snippets">

            <div class="col-md-12 col-sm-12">

                <div class="comment-wrapper">

                    <div class="panel panel-info-info">

                        <div class="panel-komentari">
                            Broj komentara : <span id="brojKomentara"></span>
                        </div>

                        <div class="panel-body">

                            <form action="" method="post">

                                <textarea id="tekst" class="form-control" placeholder="Napišite komentar..." rows="4"></textarea>

                                <br/>

                                <button type="button" id="unosKomentara" class="btn buton">Unesi</button>

                                <input type="hidden" id="vest" value="{{ $idVest }}"/>

                                <input type="hidden" id="korisnik"
                                       @if(session()->has('korisnik'))
                                            value="{{ session()->get('korisnik')->idKorisnik }}"
                                       @endif/>

                            </form>

                            <div class="clearfix" id="clearfix">

                            </div>

                            <hr>

                            <ul class="media-list" id="listaKomentara">



                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

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