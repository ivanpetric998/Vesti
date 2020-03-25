<?php


namespace App\Services;


use App\Http\Models\Korisnik;
use Illuminate\Http\Request;

class KorisnikServices
{
    public function update(Request $request,$id){

        $korisnik=new Korisnik();

        $obj=[
          'email'=>$request->input('email'),
          'username'=>$request->input('username'),
          'datumAzuriranja'=>date("Y-m-d H:i:s"),
        ];

        if($request->has('aktivan')){
            $obj['aktivan']=$request->input('aktivan');
        }
        else{
            $obj['aktivan']=null;
        }

        if($request->has('uloga')){
            $obj['idUloga']=$request->input('uloga');
        }

        $lozinka=$request->input('lozinka');

        if($lozinka!=NULL){
            $obj['password']=md5($lozinka);
        }

        $korisnik->update($obj,$id);

    }
}
