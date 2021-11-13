<?php

namespace App\Http\Controllers\Shaka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Empresa;
use App\Models\Sector;
class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $empresa = $user->empresa;
        return \Response::json(['status'=>0,'descripcion'=>'Empresa','data'=>$empresa->with('sector.puesto')->get()]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }

        try {

            $user = Auth::user();
            $campos = request()->all();
           
            $campos['empresa_id'] = $user->empresa->id;
            
            $sector = (new Sector);
            $sector->create($campos);
            

            return \Response::json(['status'=>0,'descripcion'=>'Nuevo sector agregado','data'=>\json_encode($sector)]); 
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error En la Carga del Nuevo Sector','data'=>'error:'.$th->getMessage().' Linea:'. $th->getLine()]); 
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
        //
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

    public function listarCombo(){
        $sector = Sector::combobox();
        return $sector;
    }
}
