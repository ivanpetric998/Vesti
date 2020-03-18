<?php


namespace App\Http\Models;


class Kategorija
{
    public function getAll(){
        return \DB::table('kategorija')
            ->where('aktivna',1)
            ->orderBy('pozicija')
            ->get();
    }

    public function getSveKategorije(){
        return \DB::table('kategorija')
            ->orderBy('idKategorija','desc')
            ->paginate(10);
    }

    public function insert($obj){
        \DB::table('kategorija')
            ->insert($obj);
    }

    public function delete($id){
        \DB::table('kategorija')
            ->where('idKategorija',$id)
            ->delete();
    }

    public function getKategoriju($id){
        return \DB::table('kategorija')
            ->where('idKategorija',$id)
            ->first();
    }

    public function update($obj,$id){
        \DB::table('kategorija')
            ->where('idKategorija',$id)
            ->update($obj);
    }
}