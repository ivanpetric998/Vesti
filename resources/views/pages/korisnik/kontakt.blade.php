@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - Kontakt</title>
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
        <div class="contact_area">
            <h2>Kontaktirajte nas</h2>
            <p>U slučaju bilo kakvog problema ili nedoumice, slobodno nas kontaktirajte putem naše kontakt forme ispod</p>
            <form action="{{ url('/kontakt') }}" method="post" class="contact_form">
                @csrf
                <input class="form-control" type="text" placeholder="Email" name="email">
                <input class="form-control" type="text" placeholder="Svrha poruke" name="svrha">
                <textarea class="form-control" cols="30" rows="10" placeholder="Poruka" name="poruka"></textarea>
                <input type="submit" value="Pošaljite poruku">
            </form>


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session()->has('greska'))
                {{ session()->get('greska') }}
            @endif

            @if(session()->has('poruka'))
                {{ session()->get('poruka') }}
            @endif

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