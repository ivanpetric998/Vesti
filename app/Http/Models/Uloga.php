<?php


namespace App\Http\Models;


class Uloga
{
    public function getAll(){
        return \DB::table('uloga')->get();
    }
}