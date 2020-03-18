<?php


namespace App\Http\Models;


class VestTag
{
    public function insert($obj){
        \DB::table('vesttag')->insert($obj);
    }

    public function delete($idVest){
        \DB::table('vesttag')
            ->where('idVest',$idVest)
            ->delete();
    }

    public function getTagove($idVest){
        return \DB::table('vesttag')
            ->where('idVest',$idVest)
            ->get();
    }

    public function getVesti($nizTagova){
        return \DB::table('vesttag')
            ->whereIn('idTag',$nizTagova)
            ->get();
    }

    public function deleteTag($idTag){
        \DB::table('vesttag')
            ->where('idTag',$idTag)
            ->delete();
    }

}