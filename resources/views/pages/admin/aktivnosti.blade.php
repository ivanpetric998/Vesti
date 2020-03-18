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
                    <h1>Aktivnosti na sajtu</h1>
                </div>

            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-10 offset-md-1">

                <div class="card card-primary">

                    <div class="card-header">
                        <form action="" method="get">
                            <div class="form-group row">
                                <label for="example-date-input" class="col-2 col-form-label">Filtriraj po datumu</label>
                                <div class="col-10">
                                    <input class="form-control" type="date" id="example-date-input">
                                </div>
                            </div>
                        </form>
                    </div>

                    <table id="example2_aktivnosti" class="table table-bordered table-hover">

                    </table>

                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate_aktivnosti">

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