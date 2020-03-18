@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - {{ $vest->naslov }}</title>
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

        <div class="single_page">

            <p class="linija">{{ $vest->nazivKategorija }}</p>
            <h1>{{ $vest->naslov }}</h1>
            <div class="post_commentbox">

                <a href="#">
                    <i class="fa fa-user"></i>Napisao : {{ $vest->username }}
                </a>
                    <span><i class="fa fa-calendar"></i>{{ $vest->datumKreiranja }}</span>
                <a href="#">
                    <i class="fa fa-tags">{{ $vest->nazivKategorija }}</i>
                </a>

            </div>

            <div class="single_page_content">

                <img class="img-center" src="{{ asset("/vesti/$vest->originalSlika") }}" alt="{{ $vest->naslov }}"/>

                <div>{!! $vest->tekst !!}</div>

            </div>

            <div>

                @foreach($tagovi as $i)
                    <a class="btn btn-theme" href="{{ url("/tag/{$i->idTag}") }}">{{ $i->nazivTag }}</a>
                @endforeach

            </div>




            <div class="social_link">

                <a href="{{ url("/komentari/{$vest->idVest}") }}" class="blok">Pogledaj komentare</a>

                <ul class="sociallink_nav">

                    @foreach($drustveneMreze as $i)
                        <li><a target="_blank" href="{{ $i['link'] }}"><i class="{{ $i['fa_fa'] }}"></i></a></li>
                    @endforeach

                </ul>
            </div>

            <div class="related_post">

                @if(count($povezaneVesti))

                    <h2>Povezane vesti <i class="fa fa-thumbs-o-up"></i></h2>
                    <ul class="spost_nav wow fadeInDown animated">

                @endif

                    @foreach($povezaneVesti as $i)
                        @component('partials.povezana_vest',['i'=>$i])
                        @endcomponent
                    @endforeach

                </ul>
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