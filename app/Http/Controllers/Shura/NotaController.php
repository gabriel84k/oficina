<?php

namespace App\Http\Controllers\Shura;

use App\Models\Shura\Nota;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Camus\LogController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $nota = Nota::where('user_id',$user->id)->get();
        return \Response::json(['status'=>0,'descripcion'=>'Listado de Notas','data'=>$nota]); 
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
            'nota' => 'required',
            'titulo' => 'required',
            'fecha' => 'required',
        
        ],[]); 
        
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }   
        try {     
                \DB::beginTransaction();

                $campos = $request->all();
                $campos['user_id'] = Auth::user()->id;
              
                $nota = (new Nota)->create($campos);

                \DB::commit();
                #-[Grabamos la actividad del usuario]-#
                    $log=LogController::guardar('Crear Nota','Nota Creado correctamente: '. json_encode($nota));
                return \Response::json(['status'=>0,'descripcion'=>'Se Creo con éxito la Nota','data'=>$nota]);

        } catch (\Throwable $th) {
            \DB::rollback();
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Crear la Nota ','message'=>$th->getMessage(). 'Linea: '.$th->getLine()]);
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
        $validator = Validator::make($request->all(), [
            'nota' => 'required',
            'titulo' => 'required',
            'fecha' => 'required',
        
        ],[]); 
        
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }   
        try {     
                \DB::beginTransaction();

                $campos = $request->all();
                $campos['user_id'] = Auth::user()->id;
              
                $nota = Nota::where('id',$id)->update($campos);

                \DB::commit();
                #-[Grabamos la actividad del usuario]-#
                    $log=LogController::guardar('Modificar Nota','Nota Modificada correctamente: '. json_encode($nota));
                return \Response::json(['status'=>0,'descripcion'=>'Se Modifico con éxito la Nota','data'=>$nota]);

        } catch (\Throwable $th) {
            \DB::rollback();
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Modificar la Nota ','message'=>$th->getMessage(). 'Linea: '.$th->getLine()]);
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
            $nota = Nota::find($id)->delete();
            
            #-[Grabamos la actividad del usuario]-#
            $log=LogController::guardar('Eliminación de Nota','Nota Eliminada correctamente: '. json_encode($nota));
            return \Response::json(['status'=>0,'descripcion'=>'Se Eliminada con éxito la Nota','data'=>$nota]);

        } catch (\Throwable $th) {
        
        return \Response::json(['status'=>-1,'descripcion'=>'Error al Eliminada la Nota ','message'=>$th->getMessage(). 'Linea: '.$th->getLine()]);
        }
        
    }
}
