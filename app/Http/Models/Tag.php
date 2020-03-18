<?php


namespace App\Http\Models;


class Tag
{
    public function getAll(){
        return \DB::table('tag')->get();
    }

    public function getTagoveZaVest($idVest){
        return \DB::table('tag')
            ->join('vesttag','tag.idTag','=','vesttag.idTag')
            ->where('vesttag.idVest',$idVest)
            ->get();
    }

    public function getTag(int $idTag){
        return \DB::table('tag')
            ->where('idTag',$idTag)
            ->first();
    }

    public function getSveTagove(){
        return \DB::table('tag')
            ->orderBy('idTag','desc')
            ->paginate(10);
    }

    public function insert($naziv){
        \DB::table('tag')
            ->insert(['nazivTag'=>$naziv]);
    }

    public function delete($idTag){
        \DB::table('tag')
            ->where('idTag',$idTag)
            ->delete();
    }

    public function update($naziv,$id){
        \DB::table('tag')
            ->where('idTag',$id)
            ->update(['nazivTag'=>$naziv]);
    }
}