@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - Profil</title>
    @include('fixed.korisnik.head')
@endsection

@section('header')
    @include('fixed.korisnik.header')
@endsection

@section('nav')
    @include('fixed.korisnik.nav')
@endsection

@section('center')


    <div class="row">

        <div class="col-md-8 col-md-offset-2" id="loginReg">

            <div class="panel panel-login">

                <div class="panel-heading">

                    <div class="row">
                        <div class="col-xs-12">
                            <a href="#" id="register-form-link">Profil</a>
                        </div>
                    </div>

                    <hr>

                </div>

                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-12">

                            <form id="register-form" action="{{ url("/profil/{$korisnik->idKorisnik}") }}" method="post">

                                @csrf
                                @method("PUT")

                                <div class="form-group">
                                    <input value="{{ $korisnik->email }}" type="email" name="email" id="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input value="{{ $korisnik->username }}" type="text" name="username" id="username" class="form-control" placeholder="Korisničko ime">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="lozinka" id="lozinka" class="form-control" placeholder="Lozinka">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit" class="form-control btn btn-register" value="Unos">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" value="{{ $korisnik->idKorisnik }}" name="skriveno"/>
                            </form>

                            <div id="obavestenje">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session()->has('poruka'))
                                    {{ session()->get('poruka') }}
                                @endif

                                @if(session()->has('greska'))
                                        {{ session()->get('greska') }}
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection

@section('sidebar')
    @include('fixed.korisnik.najnovije')
    {{--    @include('fixed.korisnik.najpopularnije')--}}
@endsection

@section('footer')
    @include('fixed.korisnik.footer')
@endsection

@section('scripts')
    @include('fixed.korisnik.scripts')
@endsection