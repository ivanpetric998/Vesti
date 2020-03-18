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
                    <h1>Tagovi</h1>
                </div>

            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-4 offset-1">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Unos novih tagova</h3>
                    </div>

                    <form role="form" action="{{ url('/admin/tagovi') }}" method="post">

                        @csrf

                        <div class="card-body">

                            <div class="form-group">
                                <label for="naslov">Naziv:</label>
                                <input class="form-control" type="text" name="naziv" id="naziv" placeholder="Unesite naziv taga">
                            </div>

                        </div>


                        <div class="card-footer">
                            <button type="button" id="unosTaga" class="btn btn-primary">Unos</button>
                            <button type="reset" class="btn btn-primary restart">Obriši</button>

                        </div>

                        <div id="obavestenje">

                        </div>


                    </form>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="card">

                    <div class="card-body">

                        <table id="example2_tagovi" class="table table-bordered table-hover">

                        </table>

                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate_tagovi">

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

