<?php


namespace App\Http\Models;


class Aktivnost
{

    public static function store($akcija,$ip){
        $obj=[
            'ipAdresa'=>$ip,
            'akcija'=>$akcija,
            'datum'=>date("Y-m-d H:i:s")
        ];

        \DB::table('aktivnost')
            ->insert($obj);
    }

    public function getAktivnosti($datumOd=null,$datumDo=null){

        $upit = \DB::table('aktivnost');

        if($datumOd){
            $upit->whereBetween('datum',[$datumOd,$datumDo]);
        }

        return $upit->orderBy('datum','desc')->paginate(10);
    }

}