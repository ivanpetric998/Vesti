<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
class MyController extends Controller
{
    protected function resizeText($text,$length){

        $str="$text";

        if(strlen($text)>$length){
            $str=Str::substr($text,0,$length)."...";
        }

        return $str;
    }

    protected function formatirajdatum($datum){
        return date("d-m-Y H:i",strtotime($datum));
    }

    protected function vratiGenerickuGresku(){
        return redirect()->back()->with('greska','Greška na serveru! Pokušajte kasnije');
    }

    protected function vratiGenerickuGreskuAjax(){
        return response(['greska'=>'Greška na serveru! Pokušajte kasnije'],500);
    }

    protected function formatirajNaslovObj($obj,$duzina){

        foreach($obj as $i){
            $i->naslov=$this->resizeText($i->naslov,$duzina);
        }
        return $obj;
    }



}
