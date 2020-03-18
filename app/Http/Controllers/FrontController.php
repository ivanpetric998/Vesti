<?php

namespace App\Http\Controllers;

use App\Http\Models\Kategorija;
use App\Http\Models\Tag;
use App\Http\Models\Vest;
use App\Http\Models\VestTag;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\MyController;

class FrontController extends MyController
{
    protected $data=[];
    private $kategorija;
    private $vest;
    private $tag;

    public function __construct()
    {
        $this->kategorija= new Kategorija();
        $this->vest=new Vest();
        $this->tag=new Tag();


        $this->data['najnovije']=$this->formatirajNaslovObj($this->vest->getNajnovijeVesti(),120);
        $this->data['najpopularnije']=$this->formatirajNaslovObj($this->vest->getNajpopularnijeVesti(),120);
        $this->data['kategorije']=$this->kategorija->getAll();

        $this->data['drustveneMreze']=[
          [
              'link'=>'https://sr-rs.facebook.com/',
              'text'=>'Facebook',
              'fa_fa'=>'fa fa-facebook'
          ],
            [
                'link'=>'https://twitter.com/',
                'text'=>'Twitter',
                'fa_fa'=>'fa fa-twitter'
            ],
            [
                'link'=>'https://www.instagram.com',
                'text'=>'Instagram',
                'fa_fa'=>'fa fa-instagram'
            ],
            [
                'link'=>'https://www.linkedin.com/',
                'text'=>'LinkedIn',
                'fa_fa'=>'fa fa-linkedin'
            ],
            [
                'link'=>'https://accounts.google.com/',
                'text'=>'Google-plus',
                'fa_fa'=>'fa fa-google-plus'
            ]
        ];
    }

    public function ucitajStranuZaOdredjenuKategoriju(int $idKategorija){

        $vesti=$this->vest->getVestiZaKategoriju($idKategorija);

        if(!count($vesti)){
            return view('pages.korisnik.404',$this->data);
        }

        $this->data['vesti']=$this->formatirajNaslovObj($vesti,65);
        return view('pages.korisnik.vestiZaKategoriju',$this->data);

    }

    private function getPovezaneVesti($idVest){

        $vestTag=new VestTag();
        $nizTagova=[];
        $nizVesti=[];

        $tagovi=$vestTag->getTagove($idVest);

        foreach ($tagovi as $i){
            $nizTagova[]=$i->idTag;
        }

        $vesti=$vestTag->getVesti($nizTagova);

        foreach ($vesti as $i){
            $nizVesti[]=$i->idVest;
        }

        return $this->vest->getVestiOsimJedne($nizVesti,$idVest);
    }

    public function ucitajStranuZaJednuVest(int $idVest){

        $jednaVest=$this->vest->getJednuVest($idVest);

        if(!$jednaVest){
            return view('pages.korisnik.404',$this->data);
        }

        $jednaVest->datumKreiranja=$this->formatirajdatum($jednaVest->datumKreiranja);

        $this->data['vest']=$jednaVest;
        $this->data['tagovi']=$this->tag->getTagoveZaVest($idVest);
        $this->data['povezaneVesti']=$this->formatirajNaslovObj($this->getPovezaneVesti($idVest),50);

        return view('pages.korisnik.vest',$this->data);
    }

    public function ucitajNaslovnuStranu(){

        $naslovna=$this->vest->getNaslovnu();
        $ostalo=$this->vest->getNajnovijeBezNaslovne();

        $this->data['naslovna']=$this->formatirajNaslovObj($naslovna,80);
        $this->data['ostalo']=$this->formatirajNaslovObj($ostalo,65);

        return view('pages.korisnik.pocetna',$this->data);
    }

    public function ucitajStranuZaJedanTag(int $idTag){

        $vesti=$this->vest->getVestiZaTag($idTag);

        if(!count($vesti)){
            return view('pages.korisnik.404',$this->data);
        }

        $this->data['vesti']=$this->formatirajNaslovObj($vesti,65);
        $this->data['tag']=$this->tag->getTag($idTag);

        return view('pages.korisnik.tag',$this->data);

    }

    public function ucitajStranuZaPretragu($tekst){

        $vesti=$this->vest->getVestiSaPretragom($tekst);

        $this->data['vesti']=$this->formatirajNaslovObj($vesti,60);
        $this->data['tekstZaPretragu']=$tekst;
        return view('pages.korisnik.pretraga',$this->data);

    }

}
