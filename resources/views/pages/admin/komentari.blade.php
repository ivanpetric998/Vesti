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
                    <h1>Komentari za <a target="_blank" href="{{ url("/vest/{$id}") }}">{{ $naslov }}</a> </h1>
                </div>

            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-10 offset-1">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title"><a href="{{ url('/admin/vesti/create') }}">Vrati se nazad</a> </h3>
                    </div>

                    <table class="table table-bordered table-hover">

                        <tr>
                            <th>ID</th>
                            <th>Korisničko ime</th>
                            <th>Komentar</th>
                            <th>Datum kreiranja</th>
                            <th>Obriši</th>
                        </tr>

                        @foreach($komentari as $i)
                        <tr>
                            <td>{{ $i->idKomentar }}</td>
                            <td>{{ $i->username }}</td>
                            <td>{{ $i->tekst }} </td>
                            <td>{{ $i->datumKreiranja }}</td>
                            <td>
                                <form action="{{ url("/obrisiKomentar/{$i->idKomentar}") }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Obriši" class="btn btn-primary"/>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    {{ $komentari->links() }}

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