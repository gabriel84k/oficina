<?php

namespace App\Http\Controllers\MU;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Camus\LogController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MU\Presupuesto;
use App\Models\MU\PresupuestoDetalle;


class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $user = Auth::user();

            $presupuesto=Presupuesto::with('cliente')->paginate(15);

            return \Response::json(['status'=>0,'descripcion'=>'Listado de Presupuestos','data'=>$presupuesto, 'isTipo'=>$user->tipo_id]); 

        } catch (\Throwable $th) {
            #hacer el log.
            return \Response::json(['status'=>-1,'descripcion'=>'Error en Listado','data'=>$th->getMessage()]); 
        }
      
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
            'total' => 'required|numeric',
            'titulo' => 'required',
            'subobj' => 'required|array|min:1',
        
        ],[
            'subobj' => 'Debe Seleccionar Contener al menos un Detalle',
        ]); 
        
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }   
        try {     
                \DB::beginTransaction();

                $campos = $request->all();
                $camposDetalle = $campos['subobj'];
                unset($campos['subobj']);
                
                $campos['user_id'] = Auth::user()->id;
              
                $presupuesto = (new Presupuesto)->create($campos);

                foreach ($camposDetalle as $key => $value) {
                    $camposDetalle[$key]['presupuesto_id'] = $presupuesto->id;
                    
                    $presupuestoDetalle = (new PresupuestoDetalle)->create($camposDetalle[$key]);
                }
                
                
                
                \DB::commit();
                #-[Grabamos la actividad del usuario]-#
                    $log=LogController::guardar('Crear Presupuesto','Presupuesto Creado correctamente: '. json_encode($presupuesto));
                return \Response::json(['status'=>0,'descripcion'=>'Se Creo con éxito el Presupuesto','data'=>$presupuesto]);

        } catch (\Throwable $th) {
            \DB::rollback();
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Crear el Presupuesto ','message'=>$th->getMessage(). 'Linea: '.$th->getLine()]);
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
}
