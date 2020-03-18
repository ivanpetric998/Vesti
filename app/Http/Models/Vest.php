<?php


namespace App\Http\Models;


class Vest
{
    public function insert($obj){
        return \DB::table('vest')->insertGetId($obj);
    }

    public function getAll(){
        return \DB::table('vest')->get();
    }

    public function getNaslovnu(){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->where('vest.naslovna','=','1')
            ->orderBy('datumKreiranja','desc')
            ->limit(3)
            ->select('vest.idVest','vest.naslov','slika.fitSlika','vest.tekst')
            ->get();
    }

    public function getNajnovijeBezNaslovne(){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->whereNotIn('vest.idVest',$this->getIdsNaslovnih())
            ->orderBy('datumKreiranja','desc')
            ->limit(10)
            ->select('vest.idVest','vest.naslov','slika.fitSlika','vest.tekst','kategorija.nazivKategorija')
            ->get();
    }

    private function getIdsNaslovnih(){
        $baza= \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->where('vest.naslovna','=','1')
            ->orderBy('datumKreiranja','desc')
            ->limit(3)->select('vest.idVest')
            ->get();
        $niz=[];
        foreach ($baza as $i){
            $niz[]=$i->idVest;
        }
        return $niz;
    }

    public function getJednuVest(int $idVest){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->join('korisnik','vest.idKorisnik','=','korisnik.idKorisnik')
            ->where('kategorija.aktivna',1)
            ->where('vest.idVest',$idVest)
            ->select('vest.*','kategorija.*','slika.*','korisnik.username')
            ->first();
    }

    public function getJednuVestZaAdmina(int $idVest){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->join('korisnik','vest.idKorisnik','=','korisnik.idKorisnik')
            ->where('vest.idVest',$idVest)
            ->select('vest.*','kategorija.*','slika.*','korisnik.username')
            ->first();
    }

    public function getVestiZaAdmina(){
        return \DB::table('vest')
            ->join('korisnik','vest.idKorisnik','=','korisnik.idKorisnik')
            ->orderBy('datumKreiranja','desc')
            ->select('vest.idVest','vest.naslov','korisnik.username','vest.datumKreiranja','vest.datumAzuriranja')
            ->paginate(12);
    }

    public function getVestiZaKategoriju($idKategorija){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->where('vest.idKategorija','=',$idKategorija)
            ->orderBy('datumKreiranja','desc')
            ->select('vest.idVest','vest.naslov','slika.fitSlika','vest.tekst','kategorija.nazivKategorija')
            ->simplePaginate(8);
    }

    public function getVestiZaTag(int $idTag){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->join('vesttag','vesttag.idVest','=','vest.idVest')
            ->where('kategorija.aktivna',1)
            ->where('vesttag.idTag','=',$idTag)
            ->orderBy('datumKreiranja','desc')
            ->select('vest.idVest','vest.naslov','slika.fitSlika','vest.tekst','kategorija.nazivKategorija')
            ->simplePaginate(14);
    }

    public function delete($idVest){
        \DB::table('vest')
            ->where('idVest',$idVest)
            ->delete();
    }

    public function update($obj,$id){

        \DB::table('vest')
            ->where('idVest', $id)
            ->update($obj);

    }

    public function getVestiOsimJedne($nizIdVesti,$withOutId){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->whereIn('vest.idVest',$nizIdVesti)
            ->where('vest.idVest',"<>",$withOutId)
            ->orderBy('datumKreiranja','desc')
            ->limit(3)
            ->select('vest.idVest','vest.naslov','slika.fitSlika')
            ->get();
    }

    public function getVestiSaPretragom($pretraga){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->where('vest.naslov',"LIKE","%".$pretraga."%")
            ->orderBy('datumKreiranja','desc')
            ->select('vest.idVest','vest.naslov','slika.fitSlika','vest.tekst','kategorija.nazivKategorija')
            ->simplePaginate(8);
    }

    public function getNajnovijeVesti(){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->orderBy('datumKreiranja','desc')
            ->limit(5)
            ->select('vest.idVest','vest.naslov','slika.fitSlika')
            ->get();
    }

    public function getNajpopularnijeVesti(){
        return \DB::table('vest')
            ->join('slikavest','vest.idVest','=','slikavest.idVest')
            ->join('slika','slikavest.idSlika','=','slika.idSlika')
            ->join('kategorija','kategorija.idKategorija','=','vest.idKategorija')
            ->where('kategorija.aktivna',1)
            ->whereIn('vest.idVest',Komentar::getIdsNajpopularnijihVesti())
            ->orderBy('datumKreiranja','desc')
            ->select('vest.idVest','vest.naslov','slika.fitSlika')
            ->get();
    }

}