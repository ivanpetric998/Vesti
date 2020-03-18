<?php

namespace App\Http\Controllers;

use App\Http\Models\Aktivnost;
use App\Http\Models\Korisnik;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistracijaRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\Services\KorisnikServices;
use Illuminate\Http\Request;

class AuthController extends FrontController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model=new Korisnik();
    }

    public function index(){
        return view('pages.korisnik.login',$this->data);
    }

    public function doLogin(LoginRequest $request){

        $username = $request->input("username");
        $password = $request->input("password");

        try{
            $korisnik=$this->model->getByUsernameAndPassword($username,md5($password));

            if($korisnik){

                $request->session()->put('korisnik', $korisnik);

                Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            se ulogovao",$request->ip());

                if($request->session()->get('korisnik')->nazivUloga==='admin'){
                    return redirect("/admin/aktivnosti");
                }
                else{
                    return redirect("/");
                }

            } else {
                return redirect("/login")->with("greska", "Pogrešna lozinka");
            }

        }
        catch(\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return $this->vratiGenerickuGresku();
        }

    }

    public function logout(Request $request){

        Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            se izlogovao",$request->ip());
        $request->session()->forget("korisnik");
        return redirect("/login");

    }

    public function register(RegistracijaRequest $request){

        $obj=[
            'email'=>$request->input('email'),
            'username'=>$request->input('username'),
            'password'=>md5($request->input('password')),
            'aktivan'=>1,
            'idUloga'=>2,
        ];

        try{
            $this->model->insert($obj);

            Aktivnost::store("Registracija sa username : {$obj['username']}",$request->ip());

            return response([],201);
        }
        catch (\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return $this->vratiGenerickuGreskuAjax();
        }

    }

    public function ucitajProfil($id){

        $this->data['korisnik']=$this->model->getKorisnika($id);
        return view('pages.korisnik.profil',$this->data);

    }

    public function update(UpdateProfilRequest $request,$id){
        $service=new KorisnikServices();

        try{
            $service->update($request,$id);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je izmenio svoj profil",$request->ip());

            return redirect()->back()->with('poruka',"Uspešno izmenjen profil");
        }
        catch (\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return $this->vratiGenerickuGresku();
        }
    }
}
