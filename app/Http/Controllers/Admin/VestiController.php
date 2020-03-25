<?php

namespace App\Http\Controllers\Admin;


use App\Http\Models\Aktivnost;
use App\Http\Models\Kategorija;
use App\Http\Models\Tag;
use App\Http\Models\Vest;
use App\Http\Models\VestTag;
use App\Http\Requests\InsertVestRequest;
use App\Http\Requests\UpdateVestRequest;
use Illuminate\Http\Request;
use App\Services\VestiService;
class VestiController extends AdminFrontController
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
        $this->model=new Vest();
    }

    public function index()
    {
        $vesti = $this->model->getVestiZaAdmina();

        foreach ($vesti as $i){
            $i->naslov=$this->resizeText($i->naslov,30);
            $i->datumKreiranja=$this->formatirajdatum($i->datumKreiranja);
            $i->datumAzuriranja=$this->formatirajdatum($i->datumAzuriranja);
        }

        return $vesti;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategorija=new Kategorija();
        $tag=new Tag();

        $this->data['kategorije']=$kategorija->getAll();
        $this->data['tagovi']=$tag->getAll();
        return view('pages.admin.vesti',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertVestRequest $request)
    {
        $servis=new VestiService();

        try{
            \DB::beginTransaction();
            $servis->insertVesti($request);
            \DB::commit();

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je uneo vest - {$request->input('naslov')}",$request->ip());

            return redirect()->back()->with('poruka','Uspešan unos nove vesti!');
        }
        catch (\Exception $e){
            \DB::rollBack();
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return $this->vratiGenerickuGresku();
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
        $kategorija=new Kategorija();
        $vest=$this->model->getJednuVestZaAdmina($id);

        if(!$vest){
            abort(404);
        }

        $this->data['vest']=$vest;
        $this->data['kategorije']=$kategorija->getAll();
        $this->data['tagovi']=$this->getTagoveZaPrikazAuriranjaVesti($id);

        return view('pages.admin.edit_vest',$this->data);
    }

    private function getTagoveZaPrikazAuriranjaVesti($id){

        $tag=new Tag();
        $vestTag=new VestTag();

        $tagovi=$tag->getAll();
        $korisceniTagovi=$vestTag->getTagove($id);

        foreach ($tagovi as $i){
            $i->selected=false;
        }

        foreach ($tagovi as $i){
            foreach ($korisceniTagovi as $x){
                if($x->idTag==$i->idTag){
                    $i->selected=true;
                }
            }
        }
        return $tagovi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVestRequest $request, $id)
    {
        $servis=new VestiService();

        try{
            \DB::beginTransaction();
            $servis->update($request,$id);
            \DB::commit();

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je izmenio vest - {$request->input('naslov')}",$request->ip());

            return redirect("/admin/vesti/create")->with('porukaAzuriranje','Uspešna izmena vesti!');
        }
        catch (\Exception $e){
            \DB::rollBack();
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
    public function destroy(\Request $request, $id)
    {

        $servis=new VestiService();

        try{
            \DB::beginTransaction();
            $servis->delete($id);
            \DB::commit();

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je obrisao vest sa id : {$id}",$request->ip());

            return response([],204);
        }
        catch (\Exception $e){
            \DB::rollBack();
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return response([],500);
        }

    }

}
