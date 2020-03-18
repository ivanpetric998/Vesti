@extends('layouts.admin')

@section('head')
    @include('fixed.admin.head')

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
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
                    <h1>Vesti</h1>
                </div>

            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-4">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Unos novih vesti</h3>
                    </div>

                    <form role="form" action="{{ url('/admin/vesti') }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="card-body">

                            <div class="form-group">
                                <label for="naslov">Naslov:</label>
                                <input class="form-control" type="text" name="naslov" id="naslov" placeholder="Unesite naslov">
                            </div>

                            <div class="form-group">
                                <label for="slika">Slika:</label>
                                <div class="input-group">

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="slika" name="slika">
                                        <label class="custom-file-label" for="slika">Izaberite sliku</label>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="idKategorija">Kategorija:</label>
                                <select class="form-control" id="idKategorija" name="idKategorija">
                                    <option value="0">Izaberite</option>

                                    @foreach($kategorije as $i)
                                        <option value="{{ $i->idKategorija }}">{{ $i->nazivKategorija }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tagovi">Tagovi:</label>
                                <select class="form-control" id="tagovi" name="tagovi[]" multiple>

                                    @foreach($tagovi as $i)
                                        <option value="{{ $i->idTag }}">{{ $i->nazivTag }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" value="1" class="form-check-input" name="naslovna" id="naslovna"/>
                                <label class="form-check-label" for="exampleCheck1">Naslovna</label>
                            </div>

                            <div class="form-group">
                                <label for="tekst">Tekst:</label>
                                <textarea class="form-control" name="tekst" id="summernote" placeholder="Unesite naslov" rows="4"></textarea>
                            </div>

                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Unos</button>
                            <button type="reset" class="btn btn-primary restart">Obriši</button>

                        </div>

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

                    </form>

                </div>

            </div>

            <div class="col-lg-8">

                <div class="card">


                    <div class="card-body">

                        <table id="example2" class="table table-bordered table-hover">

                        </table>

                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">

                        </div>

                        @if(session()->has('porukaAzuriranje'))
                            {{ session()->get('porukaAzuriranje') }}
                        @endif

                    </div>

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