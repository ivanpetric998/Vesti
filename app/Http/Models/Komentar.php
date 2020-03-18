<?php


namespace App\Http\Models;


use PHPUnit\Framework\Constraint\Count;

class Komentar
{
    public function delete($idVest){
        \DB::table('komentar')
            ->where('idVest',$idVest)
            ->delete();
    }

    public function obrisiKomentar($id){
        \DB::table('komentar')
            ->where('idKomentar',$id)
            ->delete();
    }

    public function getKomentare($idVest,$paginacija=false){

        $upit = \DB::table('komentar')
            ->join('korisnik','korisnik.idKorisnik','=','komentar.idKorisnik')
            ->where('komentar.idVest',$idVest)
            ->select('komentar.*','korisnik.username')
            ->orderBy('komentar.datumKreiranja','desc');

            if($paginacija){
                return $upit->simplePaginate(8);
            }
            else {
                return $upit->get();
            }

    }

    public function insert($obj){
        \DB::table('komentar')
            ->insert($obj);
    }

    public function getKomentareZaKorisnika($id){
        return \DB::table('komentar')
            ->join('vest','vest.idVest','=','komentar.idVest')
            ->where('komentar.idKorisnik',$id)
            ->select('komentar.*','vest.naslov')
            ->orderBy('komentar.datumKreiranja','desc')
            ->paginate(15);
    }

    public static function getIdsNajpopularnijihVesti(){
        $upit=\DB::select('SELECT idVest FROM komentar GROUP BY idVest ORDER BY COUNT(idVest) DESC LIMIT 5');
        $niz=[];
        foreach ($upit as $i){
            $niz[]=$i->idVest;
        }
        return $niz;
    }

}