<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Aktivnost;
use App\Http\Models\Korisnik;
use App\Http\Models\Uloga;
use App\Http\Requests\InsertKorisnikRequest;
use App\Http\Requests\UpdateKorisnikRequest;
use App\Services\KorisnikServices;
use Illuminate\Http\Request;

class KorisniciController extends AdminFrontController
{
    private $model;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $korisnici = $this->model->getAllWithRole();

        foreach ($korisnici as $i){
            $i->datumKreiranja=$this->formatirajdatum($i->datumKreiranja);
            $i->datumAzuriranja=$this->formatirajdatum($i->datumAzuriranja);
        }

        return $korisnici;
    }

    public function __construct()
    {
        parent::__construct();
        $this->model=new Korisnik();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uloga=new Uloga();
        $this->data['uloge']=$uloga->getAll();
        return view('pages.admin.korisnici',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertKorisnikRequest $request)
    {
        $obj=[
          'email'=>$request->input('email'),
          'username'=>$request->input('username'),
          'password'=>md5($request->input('lozinka')),
          'aktivan'=>$request->input('aktivan'),
          'idUloga'=>$request->input('uloga'),
        ];

        try{
            $this->model->insert($obj);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je uneo korisnika - {$obj['username']}",$request->ip());

            return response([],201);
        }
        catch(\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return $this->vratiGenerickuGreskuAjax();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uloga=new Uloga();
        $korisnik=$this->model->getKorisnika($id);

        if(!$korisnik){
            abort(404);
        }

        $this->data['uloge']=$uloga->getAll();
        $this->data['korisnik']=$korisnik;
        return view('pages.admin.edit_korisnik',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKorisnikRequest $request, $id)
    {
        $service=new KorisnikServices();

        try{
            $service->update($request,$id);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je izmenio korisnika - {$request->input('username')}",$request->ip());

            return redirect('/admin/korisnici/create')->with('porukaAzuriranje',"Uspešno izmenjen korisnik");
        }
        catch (\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return $this->vratiGenerickuGresku();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{
            $this->model->delete($id);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je obrisao korisnika sa id : {$id}",$request->ip());

            return response([],204);
        }
        catch (\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return response(['greska'=>'Ne možete izbrisati korisnika, jer se koristi negde u sistemu!'],409);
        }
    }
}
