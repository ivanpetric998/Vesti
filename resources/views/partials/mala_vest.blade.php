<li>
    <div class="media wow fadeInDown">

        <a href="{{ url("/vest/{$i->idVest}") }}" class="media-left">
            <img alt="{{ $i->naslov }}" src="{{ asset("/vesti/{$i->fitSlika}") }}">
        </a>

        <div class="media-body">
            <a href="{{ url("/vest/{$i->idVest}") }}" class="catg_title">
                {{ $i->naslov }}
            </a>
        </div>

    </div>
</li>