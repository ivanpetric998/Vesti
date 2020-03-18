<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Aktivnost;
use App\Http\Models\Kategorija;
use App\Http\Requests\InsertUpdateKategorijaRequest;
use Illuminate\Http\Request;

class KategorijeController extends AdminFrontController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model=new Kategorija();
    }

    public function index()
    {
        return $this->model->getSveKategorije();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.kategorije',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertUpdateKategorijaRequest $request)
    {
        $obj=[
          'nazivKategorija'=>$request->input('naziv'),
          'pozicija'=>$request->input('pozicija'),
          'aktivna'=>$request->input('aktivna')
        ];

        try{
            $this->model->insert($obj);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je uneo kategoriju - {$obj['nazivKategorija']}",$request->ip());

            return response([],201);
        }
        catch (\Exception $e){
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
        $kategorija=$this->model->getKategoriju($id);

        if(!$kategorija){
            abort(404);
        }

        $this->data['kategorija']=$kategorija;
        return view('pages.admin.edit_kategorija',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InsertUpdateKategorijaRequest $request, $id)
    {
        $obj=[
            'nazivKategorija'=>$request->input('naziv'),
            'pozicija'=>$request->input('pozicija'),
            'aktivna'=>$request->input('aktivna')
        ];

        try{
            $this->model->update($obj,$id);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je izmenio kategoriju - {$obj['nazivKategorija']}",$request->ip());

            return redirect('/admin/kategorije/create')->with('porukaAzuriranje','Uspešno ste izmenili kategoriju');
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
            je obrisao kategoriju sa id : {$id}",$request->ip());

            return response([],204);
        }
        catch (\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return response(['greska'=>'Ne možete izbrisati kategoriju, jer se koristi negde u sistemu!'],409);
        }
    }
}
