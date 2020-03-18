@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - Pretraga</title>
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

        @if(!count($vesti))
            <h1>Žao nam je, nema vesti za izvršenu pretragu</h1>
        @else
            <h1>Pretražuje se ključna reč : {{ $tekstZaPretragu }}</h1>
        @endif

        @foreach($vesti as $i)

            @component('partials.vest',['i'=>$i])
            @endcomponent

        @endforeach

    </div>

    <div class="row">

        <div class="col-md-6">
            {{ $vesti->links() }}
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