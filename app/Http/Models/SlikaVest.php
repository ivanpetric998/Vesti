<?php


namespace App\Http\Models;


class SlikaVest
{
    public function insert(int $idSlika, int $idVest){
        \DB::table('slikavest')->insert(
            ['idSlika' => $idSlika, 'idVest' => $idVest]
        );
    }

    public function getSlike($idVest){
        return \DB::table('slikavest')
            ->where('idVest',$idVest)
            ->get();
    }

    public function delete($idVest){
        \DB::table('slikavest')
            ->where('idVest',$idVest)
            ->delete();
    }

}