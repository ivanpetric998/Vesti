@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - Logovanje | Registracija</title>
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
                        <div class="col-xs-6">
                            <a href="#" class="active" id="login-form-link">Logovanje</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" id="register-form-link">Registracija</a>
                        </div>
                    </div>

                    <hr>

                </div>

                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-12">

                            <form id="login-form" action="{{ url('/login') }}" method="post">

                                @csrf

                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Korisničko ime">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Lozinka">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="login-submit" id="login-submit" class="form-control btn btn-login" value="Ulogujte se">
                                        </div>
                                    </div>
                                </div>



                            </form>

                            <form id="register-form" action="" method="post" style="display: none;">

                                <div class="form-group">
                                    <input type="email" name="emailReg" id="emailReg" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="usernameReg" id="usernameReg" class="form-control" placeholder="Korisničko ime">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="passwordReg" id="passwordReg" class="form-control" placeholder="Lozinka">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="passwordRegConf" id="passwordRegConf" class="form-control" placeholder="Potvrdi lozinku">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="button" name="register-submit" id="register-submit" class="form-control btn btn-register" value="Registrujte se">
                                        </div>
                                    </div>
                                </div>
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