<?php

namespace App\Http\Controllers;

use App\Http\Requests\KontaktRequest;
use App\Mail\KontaktMail;
use Illuminate\Http\Request;

class KontaktController extends FrontController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajKontaktStranu(){
        return view('pages.korisnik.kontakt',$this->data);
    }

    public function store(KontaktRequest $request){
        $obj=[
          'email'=>$request->input('email'),
          'svrha'=>$request->input('svrha'),
          'poruka'=>$request->input('poruka')
        ];

        \Mail::to('*************')->send(new KontaktMail($obj));
        return redirect()->back()->with('poruka','Uspešno ste poslali poruku');
    }
}
