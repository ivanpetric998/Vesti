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
                        <h3 class="card-title">Izmena taga</h3>
                    </div>

                    <form role="form" action="{{ url("/admin/tagovi/{$tag->idTag}") }}" method="post">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">
                                <label for="naslov">Naziv:</label>
                                <input class="form-control" type="text" value="{{ $tag->nazivTag }}" name="naziv" id="naziv" placeholder="Unesite naziv taga">
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