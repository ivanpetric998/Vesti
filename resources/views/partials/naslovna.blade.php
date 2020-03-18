<div class="single_iteam"> <a href="{{ url("/vest/{$i->idVest}") }}">
        <img src="{{ asset("vesti/{$i->fitSlika}") }}" alt="{{ $i->naslov }}">
    </a>
    <div class="slider_article">
        <h2><a class="slider_tittle" href="{{ url("/vest/{$i->idVest}") }}">{{ $i->naslov }}</a></h2>

    </div>
</div>