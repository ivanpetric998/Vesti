<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Komentar;
use App\Http\Models\Meni;
use App\Http\Models\Vest;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;
class AdminFrontController extends MyController
{
    protected $data=[];

    public function __construct()
    {
        $meni=new Meni();

        $this->data['meni']=$meni->getMenijeZaAdmina();

    }

    public function ucitajKomentareZaJednuVestZaAdmin($id){

        $vest=new Vest();
        $jednaVest=$vest->getJednuVest($id);

        if(!$jednaVest){
            abort(404);
        }

        $this->data['naslov']=$jednaVest->naslov;
        $this->data['id']=$id;

        $komentar=new Komentar();
        $komentari=$komentar->getKomentare($id,true);

        foreach($komentari as $i){
            $i->datumKreiranja=$this->formatirajdatum($i->datumKreiranja);
        }

        $this->data['komentari']=$komentari;

        return view('pages.admin.komentari',$this->data);
    }
}
