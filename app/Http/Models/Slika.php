<?php


namespace App\Http\Models;


class Slika
{
    public function insert(string $fit, string $original){
        return \DB::table('slika')->insertGetId(
            ['fitSlika' => $fit, 'originalSlika' => $original]
        );
    }

    public function delete($idSlika){
        \DB::table('slika')
            ->where('idSlika',$idSlika)
            ->delete();
    }

    public function getSliku($idSlika){
        return \DB::table('slika')
            ->where('idSlika',$idSlika)
            ->get();
    }

    public function update($obj,$id){
        \DB::table('slika')
            ->where('idSlika', $id)
            ->update($obj);
    }
}