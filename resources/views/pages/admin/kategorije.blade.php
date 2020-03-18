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
                    <h1>Kategorije</h1>
                </div>

            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-4">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Unos novih kategorija</h3>
                    </div>

                    <form role="form" action="{{ url('/admin/kategorije') }}" method="post">

                        @csrf

                        <div class="card-body">

                            <div class="form-group">
                                <label for="naslov">Naziv kategorije:</label>
                                <input class="form-control" type="text" name="naziv" id="naziv" placeholder="Unesite naziv kategorije">
                            </div>

                            <div class="form-group">
                                <label for="naslov">Pozicija:</label>
                                <input class="form-control" type="number" min="1" name="pozicija" id="pozicija"
                                       placeholder="Unesite poziciju">
                            </div>

                            <div class="form-check">
                                <input type="checkbox" value="" class="form-check-input" name="aktivna" id="aktivna">
                                <label class="form-check-label" for="aktivan">Aktivna</label>
                            </div>

                        </div>


                        <div class="card-footer">
                            <button type="button" id="unosKategorije" class="btn btn-primary">Unos</button>
                            <button type="reset" class="btn btn-primary restart">Obriši</button>

                        </div>

                        <div id="obavestenje">

                        </div>


                    </form>

                </div>

            </div>

            <div class="col-lg-8">

                <div class="card">


                    <div class="card-body">

                        <table id="example2_kategorije" class="table table-bordered table-hover">

                        </table>

                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate_kategorije">

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