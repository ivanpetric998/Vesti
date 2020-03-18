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

                </div>

            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-6 offset-3">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">Izmena vesti</h3>
                    </div>

                    <form role="form" action="{{ url("/admin/vesti/{$vest->idVest}") }}" method="post" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">
                                <label for="naslov">Naslov:</label>
                                <input class="form-control" value="{{ $vest->naslov }}" name="naslov" id="naslov" placeholder="Unesite naslov">
                            </div>

                            <div class="form-group">
                                <img id="editSlika" src="{{ asset("/vesti/{$vest->fitSlika}") }}" alt="{{ $vest->naslov }}" />
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
                                        @if($vest->idKategorija==$i->idKategorija)
                                            <option selected value="{{ $i->idKategorija }}">{{ $i->nazivKategorija }}</option>
                                        @else
                                            <option value="{{ $i->idKategorija }}">{{ $i->nazivKategorija }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tagovi">Tagovi:</label>
                                <select class="form-control" id="tagovi" name="tagovi[]" multiple>

                                    @foreach($tagovi as $i)

                                        @if($i->selected)
                                            <option selected value="{{ $i->idTag }}">{{ $i->nazivTag }}</option>
                                        @else
                                            <option value="{{ $i->idTag }}">{{ $i->nazivTag }}</option>
                                        @endif

                                    @endforeach

                                </select>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"
                                       @if($vest->naslovna==1)
                                               checked
                                       @endif
                                       value="1" class="form-check-input" name="naslovna" id="naslovna">
                                <label class="form-check-label" for="exampleCheck1">Naslovna</label>
                            </div>

                            <div class="form-group">
                                <label for="tekst">Tekst:</label>
                                <textarea class="form-control" name="tekst" id="summernoteAzuriranje"
                                          placeholder="Unesite naslov" rows="4">
                                    {{ $vest->tekst }}
                                </textarea>
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