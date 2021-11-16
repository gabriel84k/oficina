<?php

namespace App\Http\Controllers\Shaka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Tarea;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            $campos = request()->all();
            $campos['estado'] = estado($campos['estado']);

            $puesto = (new Tarea);
            
            $puesto->create($campos)->puesto()->sync($campos['puesto_id']);
            

            return \Response::json(['status'=>0,'descripcion'=>'Nueva Tarea agregado','data'=>\json_encode($puesto)]); 
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error En la Carga del Nuevo puesto','data'=>'error:'.$th->getMessage().' Linea:'. $th->getLine()]); 
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
        $tarea = Tarea::with('personal')->find($id);
        return \Response::json(['status'=>0,'descripcion'=>'Listado de Tarea','data'=>$tarea]);
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
}
