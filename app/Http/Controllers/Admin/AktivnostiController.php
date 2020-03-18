<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Aktivnost;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Parent_;

class AktivnostiController extends AdminFrontController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        return view('pages.admin.aktivnosti',$this->data);
    }

    public function getAktivnosti($datum=null){

        $datumDo=date("Y-m-d",strtotime($datum)+24*60*60);

        $aktivnost=new Aktivnost();

        try{
            $sveAktivnosti=$aktivnost->getAktivnosti($datum,$datumDo);
            return $sveAktivnosti;
        }
        catch(\Exception $e){
            $this->vratiGenerickuGreskuAjax();
        }

    }

}
