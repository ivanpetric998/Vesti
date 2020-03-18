<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="header_top">
            <div class="header_top_left">
                <ul class="top_nav">

                    @if(session()->has('korisnik'))
                        @if(session()->get('korisnik')->nazivUloga==='admin')
                            <li><a href="{{ url('/admin/aktivnosti') }}">Nazad na admin panel</a></li>
                        @else
                            <li><a href="{{ url('/profil/'.session()->get('korisnik')->idKorisnik) }}">Moj profil</a></li>
                            <li><a href="{{ url('/mojiKomentari') }}">Moji komentari</a></li>
                            <li><a href="{{ url('/logout') }}">Odjavi se</a></li>
                        @endif
                    @else
                        <li><a href="{{ url('/login') }}">Ulogujte se | Registrujte se</a></li>
                    @endif

                </ul>
            </div>
            <div class="header_top_right">
                @if(session()->has('korisnik'))
                    <p>Korisnik : {{ session()->get('korisnik')->username }}</p>
                @endif
            </div>
        </div>

    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="header_bottom">
            <div class="logo_area"><a href="{{ url('/') }}" class="logo"><img src="{{ asset('/images/logo.jpg') }}" alt=""></a></div>
            <div class="search_area">

                <form action="" method="get" id="formaZaPretragu">
                    <input type="text" id="pretraga_polje" name="pretraga_polje" class="form-control" placeholder="Pretraga po naslovu..."/>
                    <input type="button" id="pretraga" class="btn buton" value="Traži"/>
                </form>

            </div>
        </div>
    </div>

</div>