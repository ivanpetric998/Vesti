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
                        <h3 class="card-title">Izmena kategorije</h3>
                    </div>

                    <form role="form" action="{{ url("/admin/kategorije/{$kategorija->idKategorija}") }}" method="post">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">
                                <label for="naslov">Naziv kategorije:</label>
                                <input value="{{ $kategorija->nazivKategorija }}" class="form-control" type="text" name="naziv" id="naziv" placeholder="Unesite naziv kategorije">
                            </div>

                            <div class="form-group">
                                <label for="naslov">Pozicija:</label>
                                <input value="{{ $kategorija->pozicija }}" class="form-control" type="number" min="1" name="pozicija" id="pozicija"
                                       placeholder="Unesite poziciju">
                            </div>

                            <div class="form-check">
                                <input type="checkbox"
                                       @if($kategorija->aktivna==1)
                                       checked
                                       @endif
                                       value="1" class="form-check-input" name="aktivna" id="aktivna">
                                <label class="form-check-label" for="aktivan">Aktivna</label>
                            </div>

                        </div>

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