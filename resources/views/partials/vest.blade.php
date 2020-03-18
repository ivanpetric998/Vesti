<div class="fashion">
    <div class="single_post_content">
        <h2><span>{{ $i->nazivKategorija }}</span></h2>
        <ul class="business_catgnav wow fadeInDown">
            <li>
                <figure class="bsbig_fig">
                    <a href="{{ url("/vest/{$i->idVest}") }}" class="featured_img">
                        <img alt="{{ $i->naslov }}" src="{{ asset("vesti/{$i->fitSlika}") }}">
                    </a>
                    <figcaption> <a href="{{ url("/vest/{$i->idVest}") }}">{{ $i->naslov }}</a>
                    </figcaption>
                </figure>
            </li>
        </ul>

    </div>
</div>