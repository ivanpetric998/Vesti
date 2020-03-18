<?php


namespace App\Http\Models;


class Meni
{
    public function getMenijeZaAdmina(){
        return \DB::table('meni')
            ->join('menitip','meni.idMeni','=','menitip.idMeni')
            ->join('tip','tip.idTip','=','menitip.idTip')
            ->where('tip.nazivTip','=','admin')
            ->orderBy('menitip.pozicija')
            ->get();
    }
}