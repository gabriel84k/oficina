<?php

namespace App\Http\Controllers\Shaka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Personal;
use App\Models\Red;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleado = Personal::with('tarea')->paginate(15);
        return \Response::json(['status'=>0,'descripcion'=>'Todos los Empleados ','data'=>$empleado]);
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
        
        try {
            \DB::beginTransaction();
            $campos = request()->all();
            $campos['temporal'] = (boolean)$campos['temporal'];
            $campos['estado'] = (boolean)$campos['estado'];
            unset($campos['user_id']) ;
            $campos['empresa_id'] = 1;

            $red = json_decode( $campos ['red']);
            unset($campos['red']);
            
            $empleado = (new Personal);
            $empleado = $empleado->create($campos);
            
            foreach ($red as $key => $value) {
                $Reds = Red::where('personal_id',$empleado->id)
                                ->where('puesto_id',$value->puesto->id)
                                ->where('tarea_id',$value->tarea->id)
                                ->first();
                if($Reds){
                    $Reds->update(['personal_id'=>$empleado->id,'puesto_id'=>$value->puesto->id,'tarea_id'=>$value->tarea->id]);    
                }else{
                    $Reds = (new Red);
                    $Reds->create(['personal_id'=>$empleado->id,'puesto_id'=>$value->puesto->id,'tarea_id'=>$value->tarea->id]);    
                }
                                
                
               
            }
            \DB::commit();
            return \Response::json(['status'=>0,'descripcion'=>'Empleado Creado con exito ','data'=>$empleado]);
        } catch (\Throwable $th) {
            \DB::rollback();
            return \Response::json(['status'=>-1,'descripcion'=>'Error al crear el Empleados ','data'=>$th->getMessage().' Line'.$th->getLine()]);
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
        $empleado = Personal::with('tarea')->find($id);
        return \Response::json(['status'=>0,'descripcion'=>'Detalle Empleados ','data'=>$empleado]);
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
