<?php


namespace App\Http\Models;


class Korisnik
{
    public function insert($obj){
        \DB::table('korisnik')->insert($obj);
    }

    public function getAllWithRole(){
        return \DB::table('korisnik')
            ->join('uloga','korisnik.idUloga','=','uloga.idUloga')
            ->orderBy('korisnik.datumKreiranja','desc')
            ->paginate(10);
    }

    public function delete($id){
        \DB::table('korisnik')
            ->where('idKorisnik',$id)
            ->delete();
    }

    public function getKorisnika($id){
        return \DB::table('korisnik')
            ->where('idKorisnik',$id)
            ->first();
    }

    public function update($obj,$id){
        \DB::table('korisnik')
            ->where('idKorisnik',$id)
            ->update($obj);
    }

    public function getByUsernameAndPassword($username,$password){
        return \DB::table('korisnik')
            ->join('uloga','korisnik.idUloga','=','uloga.idUloga')
            ->where([
                ['korisnik.username','=',$username],
                ['korisnik.password','=',$password],
                ['korisnik.aktivan','=',1],
            ])
            ->select('korisnik.idKorisnik','korisnik.email','korisnik.username','uloga.nazivUloga','uloga.idUloga')
            ->first();
    }

}