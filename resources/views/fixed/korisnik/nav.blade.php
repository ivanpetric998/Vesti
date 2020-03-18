<nav class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav main_nav">
            <li class="active"><a href="{{ url('/') }}">Naslovna</a></li>

            @foreach($kategorije as $i)
                <li><a href="{{ url("/kategorija/{$i->idKategorija}") }}">{{ $i->nazivKategorija }}</a></li>
            @endforeach

        </ul>
    </div>
</nav>