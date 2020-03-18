@extends('layouts.admin')

@section('head')
    @include('fixed.admin.head')
@endsection

@section('header')
    @include('fixed.admin.header')
@endsection

@section('sidebar')
    @include('fixed.admin.sidebar')
@endsection

@section('center')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>

            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-6 offset-3">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Izmena korisnika</h3>
                    </div>

                    <form role="form" action="{{ url("/admin/korisnici/{$korisnik->idKorisnik}") }}" method="post">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">
                                <label for="naslov">Email:</label>
                                <input class="form-control" type="text" value="{{ $korisnik->email }}" name="email" id="email" placeholder="Unesite email">
                            </div>

                            <div class="form-group">
                                <label for="naslov">Korisničko ime:</label>
                                <input class="form-control" type="text" value="{{ $korisnik->username }}" name="username" id="username" placeholder="Unesite korisničko ime">
                            </div>

                            <div class="form-group">
                                <label for="naslov">Lozinka:</label>
                                <input class="form-control" type="password" name="lozinka" id="lozinka" placeholder="Unesite lozinku">
                            </div>


                            <div class="form-group">
                                <label for="idKategorija">Uloga:</label>
                                <select class="form-control" id="uloga" name="uloga">
                                    <option value="0">Izaberite</option>

                                    @foreach($uloge as $i)
                                        @if($korisnik->idUloga==$i->idUloga)
                                            <option selected value="{{ $i->idUloga }}">{{ $i->nazivUloga }}</option>
                                        @else
                                            <option value="{{ $i->idUloga }}">{{ $i->nazivUloga }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-check">
                                <input type="checkbox"
                                       @if($korisnik->aktivan==1)
                                       checked
                                       @endif
                                       value="1" class="form-check-input" name="aktivan" id="aktivan">
                                <label class="form-check-label" for="aktivan">Aktivan</label>
                            </div>

                        </div>

                        <input type="hidden" name="skriveno" value="{{ $korisnik->idKorisnik }}"/>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Unos</button>
                        </div>

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

                    </form>

                </div>

            </div>



        </div>

    </section>

@endsection

@section('footer')
    @include('fixed.admin.footer')
@endsection

@section('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endsection