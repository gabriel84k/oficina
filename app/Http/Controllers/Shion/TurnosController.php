<?php

namespace App\Http\Controllers\Shion;

use Illuminate\Support\Facades\Auth;
use App\Models\Shion\Turno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TurnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filtro = request()->get('filtro');
        $arrTurno=[];
        if ($filtro){
            $turnos=Turno::where('user_id',$filtro)->get();
           
        }else{
            $turnos=Turno::where('user_id',Auth::user()->id)
                            ->orwhereNull('user_id')
                            ->get();
        }
        foreach ($turnos as $key => $value) {
            array_push($arrTurno,
                [
                    'id'=>$value->id,
                    'title'=>$value->titulo,
                    'start'=>$value->fingreso,
                    'end'=>$value->fegreso,
                    'description'=> $value->detalle,//$value->detalle,
                    'icon'=>'fa fa-user'
                ]
            );

                    
        }
        return $arrTurno;
        return \Response::json(['status'=>0,'descripcion'=>'Listado de Turnos','data'=>$arrTurno]); 
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
        $campos=$request->all();
        $user = Auth::user();
        try {
            $turnos=(new Turno);
            ($campos['titulo'])?$turnos->titulo = $campos['titulo']:$turnos->titulo='Ver Nuevo ';
            
            $turnos->detalle=$campos['detalle'];
            $turnos->apellido=$campos['apellido'];
            $turnos->fegreso=str_replace("-03:00","",str_replace("T"," ",$campos['end']));
            $turnos->fingreso=str_replace("-03:00","",str_replace("T"," ",$campos['start']));
            $turnos->estado=0;
            //$turnos->turno='';
            ($campos['cliente_id'] !== '')?$turnos->cliente_id=$campos['cliente_id']:'';
            $turnos->user_id=$user->id;
            

            $turnos->save();
            return \Response::json(['status'=>0,'descripcion'=>'Turno Agregado correctamente','data'=>$turnos]); 
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error al crear el turno: '.$th->getMessage(),'data'=>'']); 
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
        
        $turnos=Turno::with(['Usuario'])->find($id);
        
        return $turnos;
        
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
        $campos=$request->all();
        $user = Auth::user();
        try {
            $turnos=Turno::find($id);
            $turnos->titulo=$campos['titulo'];
            $turnos->detalle=$campos['detalle'];
            $turnos->apellido=$campos['apellido'];
            $turnos->fegreso=str_replace("-03:00","",str_replace("T"," ",$campos['end']));
            $turnos->fingreso=str_replace("-03:00","",str_replace("T"," ",$campos['start']));
            $turnos->estado=0;
            //$turnos->turno='';
            $turnos->cliente_id=$campos['cliente_id'];
            $turnos->user_id=$user->id;

            $turnos->update();
            return \Response::json(['status'=>0,'descripcion'=>'Turno Modificado Correctamente','data'=>$turnos]); 
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Modificar el Turno: '.$th->getMessage(),'data'=>'']); 
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
        try {
            $turno=Turno::find($id);
            $turno->delete();
            return \Response::json(['status'=>0,'descripcion'=>'Turno Eliminado Correctamente','data'=>'']); 
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Eliminar el Turno: '.$th->getMessage(),'data'=>'']); 
        }
        

        
    }

    /* Funciones personalizadas */
    static function turnosemail($fecha){

        $turnos=Turno::with('Pacientes')
                     ->whereDate('fingreso',$fecha)
                     ->where('confirmado',false)
                     ->get();
        return $turnos;
    }
    static function confimaenvio($id){
        $turnos=Turno::find($id);
        $turnos->fingreso=$turnos->fingreso;
        $turnos->confirmado=true;
        $turnos->update();
    }

}
