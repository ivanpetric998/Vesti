<?php


namespace App\Services;

use App\Http\Models\Komentar;
use App\Http\Models\Slika;
use App\Http\Models\SlikaVest;
use App\Http\Models\Vest;
use App\Http\Models\VestTag;
use App\Services\ImageServices;
use Illuminate\Http\Request;
class VestiService
{
    public function insertVesti(Request $request){

        $imageService=new ImageServices("/vesti/");
        $slikaModel=new Slika();
        $vestModel=new Vest();
        $slikaVestModel=new SlikaVest();

        $slika=$request->file('slika');

        $originalSlika=$imageService->storeImage($slika);
        $fitSlika=$imageService->fitImage($originalSlika,660,502);
        $idSlika=$slikaModel->insert($fitSlika,$originalSlika);

        $objNaslov['naslov']=$request->input('naslov');
        $objNaslov['tekst']=$request->input('tekst');
        $objNaslov['datumKreiranja']=date("Y-m-d H:i:s");
        $objNaslov['datumAzuriranja']=date("Y-m-d H:i:s");
        $objNaslov['idKorisnik']=$request->session()->get('korisnik')->idKorisnik;
        $objNaslov['idKategorija']=(int)$request->input('idKategorija');
        $objNaslov['naslovna']=$request->input('naslovna');
        $idVest=$vestModel->insert($objNaslov);

        $slikaVestModel->insert($idSlika,$idVest);

        if($request->has('tagovi')){
            $nizTagova=[];

            foreach ($request->get('tagovi') as $i){
                $nizTagova[]=[
                    'idTag'=>$i,
                    'idVest'=>$idVest
                ];
            }
            $vestTagModel=new VestTag();
            $vestTagModel->insert($nizTagova);
        }

    }

    public function delete($id){

        $imageService=new ImageServices("/vesti/");
        $vestTag=new VestTag();
        $slika=new Slika();
        $slikaVest=new SlikaVest();
        $komentar=new Komentar();
        $vest=new Vest();

        $idSlike=$slikaVest->getSlike($id)[0];
        $slikaObj=$slika->getSliku($idSlike->idSlika)[0];

        $imageService->obrisiSliku($slikaObj->originalSlika);
        $imageService->obrisiSliku($slikaObj->fitSlika);

        $slikaVest->delete($id);
        $slika->delete($idSlike->idSlika);
        $komentar->delete($id);
        $vestTag->delete($id);
        $vest->delete($id);

    }

    public function update(Request $request,$id){

        if($request->has('slika')){
            $this->doUpdateSaSlikom($request,$id);
        }
        else{
            $this->doUpdateBezSlike($request,$id);
        }

    }

    private function doUpdateBezSlike(Request $request,$id){

        $vestTag=new VestTag();
        $vestTag->delete($id);

        if($request->has('tagovi')){
            $nizTagova=[];

            foreach ($request->get('tagovi') as $i){
                $nizTagova[]=[
                    'idTag'=>$i,
                    'idVest'=>$id
                ];
            }
            $vestTag->insert($nizTagova);
        }


        $obj=[
          'naslov'=>$request->input('naslov'),
          'tekst'=>$request->input('tekst'),
          'datumAzuriranja'=>date("Y-m-d H:i:s"),
          'idKategorija'=>$request->input('idKategorija'),
          'naslovna'=>$request->input('naslovna'),
        ];

        $vest=new Vest();
        $vest->update($obj,$id);

    }

    private function doUpdateSaSlikom(Request $request,$id){

        $imageService = new ImageServices("/vesti/");
        $slika=new Slika();
        $slikaVest=new SlikaVest();

        $jednaSlika=$slikaVest->getSlike($id)[0];
        $slike=$slika->getSliku($jednaSlika->idSlika)[0];

        $slikaFajl=$request->file('slika');

        $nazivOriginalSlika=$imageService->storeImage($slikaFajl);
        $nazivFitSlika=$imageService->fitImage($nazivOriginalSlika,660,502);

        $imageService->obrisiSliku($slike->fitSlika);
        $imageService->obrisiSliku($slike->originalSlika);

        $obj=[
            'fitSlika'=>$nazivFitSlika,
            'originalSlika'=>$nazivOriginalSlika,
        ];

        $slika->update($obj,$jednaSlika->idSlika);

        $this->doUpdateBezSlike($request,$id);

    }
}