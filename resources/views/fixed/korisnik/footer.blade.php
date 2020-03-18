<div class="footer_top">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="footer_widget wow fadeInLeftBig">
                <h2>Društvene mreže</h2>
                <ul class="tag_nav">

                    @foreach($drustveneMreze as $i)
                        <li><a target="_blank" href="{{ $i['link'] }}">{{ $i['text'] }}</a></li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="footer_widget wow fadeInDown">
                <h2>Kategorije</h2>
                <ul class="tag_nav">

                    @foreach($kategorije as $i)
                        <li><a href="{{ url("/kategorija/{$i->idKategorija}") }}">{{ $i->nazivKategorija }}</a></li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="footer_widget wow fadeInRightBig">
                <h2>Ostalo</h2>

                <ul class="tag_nav">
                    <li><a href="{{ url('/kontakt') }}">Kontakt</a></li>
                    <li><a href="#">Dokumentacija</a></li>
                    <li><a href="#">Autor</a></li>
                    <li><a target="_blank" href="{{ asset('sitemap.xml') }}">Site map</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="footer_bottom">
    <p class="copyright">Copyright &copy; Ivan Petrić</p>
    <p class="developer">Developed By Wpfreeware</p>
</div>