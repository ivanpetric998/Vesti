<?php

namespace App\Http\Controllers;

use App\Http\Models\Aktivnost;
use App\Http\Models\Komentar;
use App\Http\Models\Vest;
use App\Http\Requests\InsertKomentarRequest;
use Illuminate\Http\Request;

class KomentariController extends FrontController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model=new Komentar();
    }

    public function ucitajStranu($id){
        $vest=new Vest();
        $jednaVest=$vest->getJednuVest($id);
        if($jednaVest){
            $this->data['idVest']=$jednaVest->idVest;
            $this->data['naslov']=$jednaVest->naslov;
            return view('pages.korisnik.komentari',$this->data);
        }

        abort('404');
    }

    public function ucitajStranuZaMojeKomentare(){

        return view('pages.korisnik.moji_komentari',$this->data);

    }

    public function ucitajMojeKomentare(Request $request){

        $id=$request->session()->get('korisnik')->idKorisnik;
        $komentari=$this->model->getKomentareZaKorisnika($id);

        foreach ($komentari as $i){
            $i->naslov=$this->resizeText($i->naslov,25);
            $i->datumKreiranja=$this->formatirajdatum($i->datumKreiranja);
        }

        return $komentari;
    }


    public function getKomentare($id){
        return $this->model->getKomentare($id);
    }

    public function store(InsertKomentarRequest $request){

        $obj=[
          'idVest'=>$request->input('vest'),
          'idKorisnik'=>$request->input('korisnik'),
          'tekst'=>$request->input('tekst'),
          'datumKreiranja'=>date("Y-m-d H:i:s")
        ];

        try{
            $this->model->insert($obj);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je komentarisao vest sa id : {$obj['idVest']}",$request->ip());

            return response([],201);
        }
        catch (\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            $this->vratiGenerickuGreskuAjax();
        }

    }

    public function destroy(Request $request, $id){

        $accept=$request->header('Accept');

        try{
            $this->model->obrisiKomentar($id);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je obrisao komentar sa id : {$id}",$request->ip());

            if($accept==='application/json') {
                return response([],204);
            }

            return redirect()->back();

        }
        catch(\Exception $e){

            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());

            if($accept==='application/json') {
                return $this->vratiGenerickuGreskuAjax();
            }

            return $this->vratiGenerickuGresku();

        }

    }

}
