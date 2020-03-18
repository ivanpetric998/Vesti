const baseUrl="http://localhost:8000/";
const regExForEditPost=new RegExp(`^${baseUrl}admin\/vesti\/[0-9]+\/edit$`);
const regExForAdminNewsPage=new RegExp(`^${baseUrl}admin/vesti/create[\#]?$`);
const regExForAdminUsersPage=new RegExp(`^${baseUrl}admin/korisnici/create[\#]?$`);
const regExForAdminTagsPage=new RegExp(`^${baseUrl}admin/tagovi/create[\#]?$`);
const regExForAdminCategoryPage=new RegExp(`^${baseUrl}admin/kategorije/create[\#]?$`);
const regExForActivityPage=new RegExp(`^${baseUrl}admin/aktivnosti[\#]?$`);
const regExForLoginRegisterPage=new RegExp(`^${baseUrl}login[\#]?$`);
const regExForCommentPage=new RegExp(`^${baseUrl}komentari/[0-9]+[\#]?$`);
const regExForMyCommentsPage=new RegExp(`^${baseUrl}mojiKomentari[\#]?$`);

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click",".rucna-paginacija",function (e) {

        e.preventDefault();

        let page=$(this).data('page');

        $.ajax({
            url:page,
            dataType:'json',
            method:"get",
            success:function (data) {

                switch (window.location.href) {
                    case baseUrl+"admin/vesti/create" :
                    case baseUrl+"admin/vesti/create#" :
                        ispisiSveVestiZaAdmina(data.data);
                        break;
                    case baseUrl+"admin/korisnici/create" :
                    case baseUrl+"admin/korisnici/create#" :
                        ispisiSveKorisnikeZaAdmina(data.data);
                        break;
                    case baseUrl+"admin/tagovi/create" :
                    case baseUrl+"admin/tagovi/create#" :
                        ispisiSveTagoveZaAdmina(data.data);
                        break;
                    case baseUrl+"admin/kategorije/create" :
                    case baseUrl+"admin/kategorije/create#" :
                        ispisiSveKategorijeZaAdmina(data.data);
                        break;
                    case baseUrl+"mojiKomentari" :
                    case baseUrl+"mojiKomentari#" :
                        ispisiMojeKomentare(data.data);
                        break;
                    case baseUrl+"admin/aktivnosti" :
                    case baseUrl+"admin/aktivnosti#" :
                        ispisiAktivnosti(data.data);
                        break;
                }

            },
            error:function (xhr,status,error) {
                alert(xhr.status)
            }
        });
    });

    $(".restart").click(function () {
        $("#obavestenje").html("");
    });

    $("#pretraga").click(function () {

        let polje_za_pretragu=$("#pretraga_polje").val().trim();

        if(polje_za_pretragu==""){
            return false;
        }

        window.location.href=baseUrl+"pretraga/"+polje_za_pretragu;
    });

    if(regExForCommentPage.test(window.location.href)){
        ucitajSveKomentare();

        $("#unosKomentara").click(function () {

            let data={
                tekst:$("#tekst").val(),
                korisnik:$("#korisnik").val(),
                vest:$("#vest").val()
            };

            $.ajax({
                url:'/komentar',
                dataType:'json',
                method:"post",
                headers: {
                    'Accept': 'application/json'
                },
                data:data,
                success:function (data,status,xhr) {
                    if(xhr.status==201){
                        $("#clearfix").html("Uspešno ste ostavili komentar");
                        ucitajSveKomentare();
                        $("#tekst").val("");
                    }
                },
                error:function (xhr,status,error) {

                    if(xhr.status==422){
                        let ispis=izvrsiObraduParametarskihGresaka(xhr);
                        $("#clearfix").html(ispis)
                    }

                    if(xhr.status==500){
                        let greska=JSON.parse(xhr.responseText);
                        $("#clearfix").html(greska.greska)
                    }

                    if(xhr.status==403){
                        $("#clearfix").html("Ne možete ostaviti komentar, jer niste ulogovani");
                    }

                }
            })

        });
    }

    if(regExForLoginRegisterPage.test(window.location.href)){

        $('#login-form-link').click(function(e) {
            $("#login-form").delay(100).fadeIn(100);
            $("#register-form").fadeOut(100);
            $('#register-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
        $('#register-form-link').click(function(e) {
            $("#register-form").delay(100).fadeIn(100);
            $("#login-form").fadeOut(100);
            $('#login-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });

        $("#register-submit").click(function () {

            let data={
                username:$("#usernameReg").val(),
                email:$("#emailReg").val(),
                password:$("#passwordReg").val(),
                passwordConf:$("#passwordRegConf").val(),
            };

            console.log(data)

            let greske=izvrsiProveruZaRegistraciju(data);

            if(greske!=null){
                $("#obavestenje").html(greske);
            }
            else{

                $.ajax({
                    url:'/register',
                    dataType:'json',
                    method:"post",
                    headers: {
                        'Accept': 'application/json'
                    },
                    data:data,
                    success:function (data,status,xhr) {
                        if(xhr.status==201){
                            $("#obavestenje").html("Uspešna registracija");
                            restartujFormuZaRegistraciju();
                        }
                    },
                    error:function (xhr,status,error) {

                        if(xhr.status==422){
                            let ispis=izvrsiObraduParametarskihGresaka(xhr);
                            $("#obavestenje").html(ispis)
                        }

                        if(xhr.status==500){
                            let greska=JSON.parse(xhr.responseText);
                            $("#obavestenje").html(greska.greska)
                        }

                    }
                })

            }
        })
    }

    if(regExForEditPost.test(window.location.href)){
        $('#summernoteAzuriranje').summernote();
    }

    if(regExForAdminNewsPage.test(window.location.href)){

        $('#summernote').summernote();
        ucitajAdminVesti();

        $(document).on("click", ".obrisi_vest", function () {
            let id=$(this).data('id');

            $.ajax({
                url:"/admin/vesti/"+id,
                method:"delete",
                success:function (data,status,xhr) {

                    if(xhr.status===204){
                        ucitajAdminVesti();
                    }

                },
                error:function (xhr,status,error) {
                    alert(xhr.status)
                }
            })
        })
    }

    if(regExForAdminUsersPage.test(window.location.href)){

        $("#aktivan").click(function () {
            if($(this).prop('checked')){
                $(this).val("1");
            }
            else{
                $(this).val("");
            }
        });

        ucitajKorisnikeZaAdmina();

        $("#unosKorisnika").click(function () {

            data={
                email:$("#email").val().trim(),
                username:$("#username").val().trim(),
                lozinka:$("#lozinka").val().trim(),
                uloga:$("#uloga").val(),
                aktivan:$("#aktivan").val(),
            };

            $.ajax({
                url:'/admin/korisnici',
                dataType:'json',
                method:"post",
                headers: {
                    'Accept': 'application/json'
                },
                data:data,
                success:function (data,status,xhr) {
                    if(xhr.status==201){
                        $("#obavestenje").html("Uspešan unos korisnika");
                        ucitajKorisnikeZaAdmina();
                        restartujFormuZaUnosKorisnika();
                    }
                },
                error:function (xhr,status,error) {

                    if(xhr.status==422){
                        let ispis=izvrsiObraduParametarskihGresaka(xhr);
                        $("#obavestenje").html(ispis)
                    }

                    if(xhr.status==500){
                        let greska=JSON.parse(xhr.responseText);
                        $("#obavestenje").html(greska.greska)
                    }

                }
            })
        });

        $(document).on("click", ".obrisi_korisnika", function () {
            let id=$(this).data('id');

            $.ajax({
                url:'/admin/korisnici/'+id,
                method:"delete",
                success:function (data,status,xhr) {
                    if(xhr.status==204){
                        ucitajKorisnikeZaAdmina();
                    }
                },
                error:function (xhr,status,error) {
                    if(xhr.status==409){
                        let greska=JSON.parse(xhr.responseText);
                        alert(greska.greska)
                    }
                }
            })
        })
    }

    if(regExForAdminTagsPage.test(window.location.href)){

        ucitajTagoveZaAdmina();

        $("#unosTaga").click(function () {

            let data={
                naziv:$("#naziv").val().trim()
            };

            $.ajax({
                url:'/admin/tagovi',
                dataType:'json',
                method:"post",
                headers: {
                    'Accept': 'application/json'
                },
                data:data,
                success:function (data,status,xhr) {
                    if(xhr.status==201){
                        $("#obavestenje").html("Uspešan unos taga");
                        ucitajTagoveZaAdmina();
                        $("#naziv").val("");
                    }
                },
                error:function (xhr,status,error) {

                    if(xhr.status==422){
                        let ispis=izvrsiObraduParametarskihGresaka(xhr);
                        $("#obavestenje").html(ispis)
                    }

                    if(xhr.status==500){
                        let greska=JSON.parse(xhr.responseText);
                        $("#obavestenje").html(greska.greska)
                    }

                }
            });
        });

        $(document).on('click',".obrisi_tag", function () {
            let id=$(this).data('id');

            $.ajax({
                url:'/admin/tagovi/'+id,
                method:"delete",
                success:function (data,status,xhr) {
                    if(xhr.status==204){
                        ucitajTagoveZaAdmina();
                    }
                },
                error:function (xhr,status,error) {
                    if(xhr.status==409){
                        let greska=JSON.parse(xhr.responseText);
                        alert(greska.greska)
                    }
                }
            })
        })
    }

    if(regExForAdminCategoryPage.test(window.location.href)){

        ucitajKategorijeZaAdmina();

        $("#aktivna").click(function () {
            if($(this).prop('checked')){
                $(this).val("1");
            }
            else{
                $(this).val("");
            }
        });

        $("#unosKategorije").click(function () {

            let data={
                naziv:$("#naziv").val(),
                pozicija:$("#pozicija").val(),
                aktivna:$("#aktivna").val(),
            };

            $.ajax({
                url:'/admin/kategorije',
                dataType:'json',
                method:"post",
                headers: {
                    'Accept': 'application/json'
                },
                data:data,
                success:function (data,status,xhr) {
                    if(xhr.status==201){
                        $("#obavestenje").html("Uspešan unos kategorije");
                        ucitajKategorijeZaAdmina();
                        $("#naziv").val("");
                        $("#pozicija").val("");
                        $("#aktivna").attr("checked",false);
                    }
                },
                error:function (xhr,status,error) {

                    if(xhr.status==422){
                        let ispis=izvrsiObraduParametarskihGresaka(xhr);
                        $("#obavestenje").html(ispis)
                    }

                    if(xhr.status==500){
                        let greska=JSON.parse(xhr.responseText);
                        $("#obavestenje").html(greska.greska)
                    }

                }
            });

        });

        $(document).on("click", ".obrisi_kategoriju", function () {
            let id=$(this).data('id');

            $.ajax({
                url:'/admin/kategorije/'+id,
                method:"delete",
                success:function (data,status,xhr) {
                    if(xhr.status==204){
                        ucitajKategorijeZaAdmina();
                    }
                },
                error:function (xhr,status,error) {
                    if(xhr.status==409){
                        let greska=JSON.parse(xhr.responseText);
                        alert(greska.greska)
                    }
                }
            });
        })
    }

    if(regExForMyCommentsPage.test(window.location.href)){

        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('whatever');

            var modal = $(this);
            modal.find('.modal-title').text('New message to ' + recipient);
            modal.find('.modal-body textarea').val(recipient);
        });

        ucitajMojeKomentare();

        $(document).on("click",'.obrisi-komentar',function () {
            let id=$(this).data("id");

            $.ajax({
                url:'/obrisiKomentar/'+id,
                method:"delete",
                headers: {
                    'Accept': 'application/json'
                },
                success:function (data,status,xhr) {
                    if(xhr.status==204){
                        ucitajMojeKomentare();
                    }
                },
                error:function (xhr,status,error) {
                    if(xhr.status==500){
                        let greska=JSON.parse(xhr.responseText);
                        alert(greska.greska)
                    }
                }
            });

        });
    }

    if(regExForActivityPage.test(window.location.href)){

        $("#example-date-input").val(getDanasnjiDan());

        ucitajAktivnosti(getDanasnjiDan());

        $("#example-date-input").change(function () {
            let datum=$(this).val();
            ucitajAktivnosti(datum);
        });
    }

});

function ucitajSveKomentare() {

    let niz=window.location.href.split('/');
    let poslednjiClan=niz[niz.length-1];
    let id=poslednjiClan.split('#')[0];


    $.ajax({
        url:'/komentariZaVest/'+id,
        dataType:'json',
        method:"get",
        success:function (data) {
            ispisiKomentare(data);
        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

function ispisiKomentare(data) {
    let ispis=``;

    for(let i of data){
        ispis+=`<li class="media">
                    <a href="#" class="pull-left">
                       <img src="${baseUrl+'/images/user.png'}" alt="slika korisnika" class="img-circle">
                    </a>
                    <strong class="text-success">${i.username}</strong>
                        <span class="spanRight">${formatirajDatum(i.datumKreiranja)}</span>
                    <p>${i.tekst}</p>
                </li>`;
    }

    $("#brojKomentara").html(data.length);

    $("#listaKomentara").html(ispis);
}


function ucitajMojeKomentare() {
    $.ajax({
        url:'/dohvatiMojeKomentare',
        dataType:'json',
        method:"get",
        success:function (data) {
            let brojLinkovaZaPaginaciju=Math.ceil(data.total/data.per_page);
            ispisiPaginaciju(brojLinkovaZaPaginaciju,data.path);
            ispisiMojeKomentare(data.data);
        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

function ispisiMojeKomentare(data) {
    let ispis=``;

    for(let i of data){
        ispis+=`<tr>
                    <td><a target="_blank" href="/vest/${i.idVest}" class="linkovi">${i.naslov}</a></td>
                    <td><a href="#" class="linkovi" data-toggle="modal" data-target="#exampleModal" data-whatever="${i.tekst}">Prikazi tekst</a></td>
                    <td>${i.datumKreiranja}</td>
                    <td><a class="linkovi obrisi-komentar" data-id="${i.idKomentar}" href="#">Obriši</a></td>
                </tr>`;
    }

    $("#teloTabeleMojiKomentari").html(ispis);
}


function formatirajDatum(date) {
    let fulldatum=date.split(' ');
    let datum=fulldatum[0].split('-');
    let vreme=fulldatum[1].split(':');

    return `${datum[2]}-${datum[1]}-${datum[0]} ${vreme[0]}:${vreme[1]}`;
}

function getDanasnjiDan() {

    let date=new Date();

    let dan=("0" + date.getDate()).slice(-2);
    let mesec=("0" + (date.getMonth() + 1)).slice(-2);
    let godina=date.getFullYear();

    return `${godina}-${mesec}-${dan}`;
}


function ucitajAktivnosti(datum) {

    if(datum){
        datum="/"+datum;
    }

    $.ajax({
        url:"aktivnosti/json"+datum,
        method:"get",
        dataType:"json",
        success:function (data) {
            let brojLinkovaZaPaginaciju=Math.ceil(data.total/data.per_page);
            ispisiPaginaciju(brojLinkovaZaPaginaciju,data.path);
            ispisiAktivnosti(data.data);
        },
        error:function (xhr,status,error) {
            if(xhr.status==500){
                izvrsiObraduParametarskihGresaka(xhr);
            }
        }
    });

}

function ispisiAktivnosti(data) {
    let br=1;
    let ispis=`<tr>
                  <th width="3%">RB</th>
                  <th width="70%">Aktivnost koja se desila</th>
                  <th width="13%">Ip adresa</th>
                  <th width="14%">Datum</th>
               </tr>`;
    for(let i of data){
        ispis+=`<tr>
                    <td>${br++}</td>
                    <td>${i.akcija}</td>
                    <td>${i.ipAdresa}</td>
                    <td>${formatirajDatum(i.datum)}</td>
                </tr>`;
    }

    $("#example2_aktivnosti").html(ispis);

}


function ispisiPaginaciju(links,url) {

    let ispis=`<ul class="pagination">`;
    for(let i=1;i<=links;i++){
        ispis+=`<li class="page-item"><a class="page-link rucna-paginacija" data-page="${url+"?page="+i}" href="#">${i}</a></li>`;
    }
    ispis+=`</ul>`;

    switch (window.location.href) {
        case baseUrl+"admin/vesti/create" :
        case baseUrl+"admin/vesti/create#" :
            $("#example2_paginate").html(ispis);
            break;
        case baseUrl+"admin/korisnici/create" :
        case baseUrl+"admin/korisnici/create#" :
            $("#example2_paginate_korisnici").html(ispis);
            break;
        case baseUrl+"admin/tagovi/create" :
        case baseUrl+"admin/tagovi/create#" :
            $("#example2_paginate_tagovi").html(ispis);
            break;
        case baseUrl+"admin/kategorije/create" :
        case baseUrl+"admin/kategorije/create#" :
            $("#example2_paginate_kategorije").html(ispis);
            break;
        case baseUrl+"mojiKomentari" :
        case baseUrl+"mojiKomentari#" :
            $("#paginacijaKomentariKorisnik").html(ispis);
            break;
        case baseUrl+"admin/aktivnosti" :
        case baseUrl+"admin/aktivnosti#" :
            $("#example2_paginate_aktivnosti").html(ispis);
            break;
    }



}

function izvrsiObraduParametarskihGresaka(xhr) {

    let greska=JSON.parse(xhr.responseText).errors;
    Object.keys(greska);

    let ispis=`<div class="alert alert-danger"<ul>`;

    for(let i of Object.values(greska)){
        ispis+=`<li>${i[0]}</li>`
    }

    ispis+=`</ul></div>`;

    return ispis;
}


function ucitajAdminVesti() {
    $.ajax({
        url:'/admin/vesti',
        dataType:'json',
        method:"get",
        success:function (data) {
            let brojLinkovaZaPaginaciju=Math.ceil(data.total/data.per_page);
            ispisiPaginaciju(brojLinkovaZaPaginaciju,data.path);
            ispisiSveVestiZaAdmina(data.data);
        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

function ispisiSveVestiZaAdmina(data) {
    let ispis=`<tr>
                  <th>ID</th>
                  <th>Naslov(Komentari)</th>
                  <th>Korisnik</th>
                  <th>Kreirano</th>
                  <th>Izmenjeno</th>
                  <th>Izmeni</th>
                  <th>Obriši</th>
               </tr>`;
    for(let i of data){
        ispis+=`<tr>
                    <td>${i.idVest}</td>
                    <td><a href="/admin/komentari/${i.idVest}">${i.naslov}</a></td>
                    <td>${i.username}</td>
                    <td>${i.datumKreiranja}</td>
                    <td>${i.datumAzuriranja}</td>
                    <td><a href="/admin/vesti/${i.idVest}/edit" data-id="${i.idVest}">Izmeni</a></td>
                    <td><a href="#" data-id="${i.idVest}" class="obrisi_vest">Obriši</a></td>
                 </tr>`;
    }

    $("#example2").html(ispis);
}


function ucitajKorisnikeZaAdmina() {
    $.ajax({
        url:'/admin/korisnici',
        dataType:'json',
        method:"get",
        success:function (data) {
            let brojLinkovaZaPaginaciju=Math.ceil(data.total/data.per_page);
            ispisiPaginaciju(brojLinkovaZaPaginaciju,data.path);
            ispisiSveKorisnikeZaAdmina(data.data);
        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

function ispisiSveKorisnikeZaAdmina(data) {
    let ispis=`<tr>
                  <th>ID</th>
                  <th>Korisničko ime</th>
                  <th>Uloga</th>
                  <th>Kreirano</th>
                  <th>Izmenjeno</th>
                  <th>Izmeni</th>
                  <th>Obriši</th>
               </tr>`;
    for(let i of data){
        ispis+=`<tr>
                     <td>${i.idKorisnik}</td>
                    <td>${i.username}</td>
                    <td>${i.nazivUloga}</td>
                    <td>${i.datumKreiranja}</td>
                    <td>${i.datumAzuriranja}</td>
                    <td><a href="/admin/korisnici/${i.idKorisnik}/edit" data-id="${i.idKorisnik}">Izmeni</a></td>
                    <td><a href="#" data-id="${i.idKorisnik}" class="obrisi_korisnika">Obriši</a></td>
                 </tr>`;
    }

    $("#example2_korisnici").html(ispis);
}

function restartujFormuZaUnosKorisnika() {
        $("#email").val("");
        $("#username").val("");
        $("#lozinka").val("");
        $("#uloga").val("0");
        $("#aktivan").attr("checked",false);
}


function ucitajTagoveZaAdmina() {
    $.ajax({
        url:'/admin/tagovi',
        dataType:'json',
        method:"get",
        success:function (data) {
            let brojLinkovaZaPaginaciju=Math.ceil(data.total/data.per_page);
            ispisiPaginaciju(brojLinkovaZaPaginaciju,data.path);
            ispisiSveTagoveZaAdmina(data.data);
        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

function ispisiSveTagoveZaAdmina(data) {
    let ispis=`<tr>
                  <th>ID</th>
                  <th>Naziv</th>
                  <th>Izmeni</th>
                  <th>Obriši</th>
               </tr>`;
    for(let i of data){
        ispis+=`<tr>
                     <td>${i.idTag}</td>
                    <td>${i.nazivTag}</td>
                    <td><a href="/admin/tagovi/${i.idTag}/edit" data-id="${i.idTag}">Izmeni</a></td>
                    <td><a href="#" data-id="${i.idTag}" class="obrisi_tag">Obriši</a></td>
                 </tr>`;
    }

    $("#example2_tagovi").html(ispis);
}


function ucitajKategorijeZaAdmina() {
    $.ajax({
        url:'/admin/kategorije',
        dataType:'json',
        method:"get",
        success:function (data) {
            let brojLinkovaZaPaginaciju=Math.ceil(data.total/data.per_page);
            ispisiPaginaciju(brojLinkovaZaPaginaciju,data.path);
            ispisiSveKategorijeZaAdmina(data.data);
        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

function ispisiSveKategorijeZaAdmina(data) {
    let ispis=`<tr>
                  <th>ID</th>
                  <th>Naziv</th>
                  <th>Pozicija</th>
                  <th>Aktivna</th>
                  <th>Izmeni</th>
                  <th>Obriši</th>
               </tr>`;
    for(let i of data){
        ispis+=`<tr>
                     <td>${i.idKategorija}</td>
                    <td>${i.nazivKategorija}</td>
                    <td>${i.pozicija}</td>`;

            if(i.aktivna==null){
                ispis+=`<td>Ne</td>`;
            }
            else{
                ispis+=`<td>Da</td>`;
            }

            ispis+=`<td><a href="/admin/kategorije/${i.idKategorija}/edit" data-id="${i.idKategorija}">Izmeni</a></td>
                    <td><a href="#" data-id="${i.idKategorija}" class="obrisi_kategoriju">Obriši</a></td>
                 </tr>`;
    }

    $("#example2_kategorije").html(ispis);
}



function izvrsiProveruZaRegistraciju(data) {

    let regEmail=/^[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$/;
    let regUsername=/^[\d\w\_\-\.\@]{6,30}$/;
    let regPassword=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;

    let greske=[];
    let ispis=`<div class="alert alert-danger"<ul>`;

    if(!regEmail.test(data.email)){
        greske.push('Email nije u dobrom formatu');
    }

    if(!regUsername.test(data.username)){
        greske.push('Korisničko ime nije u dobrom formatu');
    }

    if(!regPassword.test(data.password)){
        greske.push('Lozinka nije u dobrom formatu');
    }

    if(data.passwordConf!=data.password){
        greske.push('Lozinke nisu iste');
    }

    if(greske.length){

        for(let i of greske){
            ispis+=`<li>${i}</li>`;
        }

        ispis+=`</li></div>`;

        return ispis;
    }

    return null;
}

function restartujFormuZaRegistraciju() {

        $("#usernameReg").val("");
        $("#emailReg").val("");
        $("#passwordReg").val("");
        $("#passwordRegConf").val("");

}