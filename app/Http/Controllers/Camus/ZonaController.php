<?php

namespace App\Http\Controllers\Camus;
use App\Models\Camus\Zona;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    public function combozona(){
        $zona = Zona::select("nombre","id","estado")->orderby('id','ASC')->get();
                  
        return $zona;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            $campos = request()->get('nombre');
            $zona = (new Zona);
            $zona->nombre = $campos;
            $zona->dia = 'lunes';
            $zona->save();
            return \Response::json(['status'=>0,'descripcion'=>'Se Guardo Correctamente','data'=>$zona]);    //code...
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error no se Guardo','data'=>$th->getMessage()]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            
            $zona = Zona::find($id);
            if ($zona->estado == 1){
                $zona->estado = 0;
            }else{
                $zona->estado = 1;
            }
            $zona->update();
            return \Response::json(['status'=>0,'descripcion'=>'Se Guardo Correctamente','data'=>$zona]);    //code...
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error no se Guardo','data'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
