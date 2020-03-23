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
        
        try{
           \Mail::to('*************')->send(new KontaktMail($obj));
            Aktivnost::store("Poslata pouka",$request->ip());
            return redirect()->back()->with('poruka','Uspešno ste poslali poruku');
        }
        catch(\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return redirect()->back()->with('greska','Greška na serveru! Molimo pokušajte kasnije');
        }
        
    }
}
