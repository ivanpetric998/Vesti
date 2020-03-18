<li>
    <div class="media">
        <a class="media-left" href="{{ url("/vest/{$i->idVest}") }}">
            <img src="{{ asset("/vesti/$i->fitSlika") }}" alt="{{ $i->naslov }}">
        </a>
        <div class="media-body">
            <a class="catg_title" href="{{ url("/vest/{$i->idVest}") }}">{{ $i->naslov }}</a>
        </div>
    </div>
</li>