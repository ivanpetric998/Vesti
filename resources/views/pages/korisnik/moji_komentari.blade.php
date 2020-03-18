@extends('layouts.korisnik')

@section('head')
    <title>Sportske vesti - Moji komentari</title>
    @include('fixed.korisnik.head')
@endsection

@section('header')
    @include('fixed.korisnik.header')
@endsection

@section('nav')
    @include('fixed.korisnik.nav')
@endsection

@section('center')

    <div class="left_content">

        <h1>Moji komentari</h1>

        <table class="table table-borderless">
            <thead>
            <tr>
                <th scope="col">Vest</th>
                <th scope="col">Tekst</th>
                <th scope="col">Datum kreiranja</th>
                <th scope="col">Obriši</th>
            </tr>
            </thead>
            <tbody id="teloTabeleMojiKomentari">

            </tbody>
        </table>

        <div id="paginacijaKomentariKorisnik">

        </div>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Komentar:</label>
                            <textarea disabled="disabled" class="form-control" rows="8" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('sidebar')
    @include('fixed.korisnik.najnovije')
@endsection

@section('footer')
    @include('fixed.korisnik.footer')
@endsection

@section('scripts')
    @include('fixed.korisnik.scripts')
@endsection