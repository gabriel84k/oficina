<?php

namespace App\Http\Controllers\Shaka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Funciones\Funciones;

use App\Models\Puesto;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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

            $puesto = (new Puesto);
            
            $puesto->create($campos)->sector()->attach($campos['sector_id']);
            

            return \Response::json(['status'=>0,'descripcion'=>'Nuevo puesto agregado','data'=>\json_encode($puesto)]); 
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
        $puesto = Puesto::with(['personal.tarea', 'tarea'])->find($id);
        return \Response::json(['status'=>0,'descripcion'=>'Listados de Empleados por puestos y tareas por empleados','data'=>$puesto]);
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
