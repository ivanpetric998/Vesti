<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Aktivnost;
use App\Http\Models\Tag;
use App\Http\Requests\InsertUpdateTagRequest;
use App\Services\TagServices;
use Doctrine\Instantiator\Exception\ExceptionInterface;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class TagoviController extends AdminFrontController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model=new Tag();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->getSveTagove();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.tagovi',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertUpdateTagRequest $request)
    {
        $naziv=$request->input('naziv');

        try{
            $this->model->insert($naziv);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je uneo tag sa - {$naziv}",$request->ip());

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
        $tag=$this->model->getTag($id);

        if(!$tag){
            abort(404);
        }

        $this->data['tag']=$tag;
        return view('pages.admin.edit_tag', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InsertUpdateTagRequest $request, $id)
    {
        $naziv=$request->input('naziv');

        try{
            $this->model->update($naziv,$id);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je izmenio tag - {$naziv}",$request->ip());

            return redirect('/admin/tagovi/create')->with('porukaAzuriranje','Uspešna izmena taga');
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
    public function destroy(Request $request,$id)
    {
        $service=new TagServices();

        try{
            $service->delete($id);

            Aktivnost::store("Korisnik {$request->session()->get('korisnik')->username} 
            je obrisao tag sa id : {$id}",$request->ip());

            return response([],204);
        }
        catch (\Exception $e){
            Aktivnost::store("Greška : {$e->getMessage()}",$request->ip());
            return $this->vratiGenerickuGreskuAjax();
        }
    }
}
