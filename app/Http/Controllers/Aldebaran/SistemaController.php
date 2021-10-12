<?php

namespace App\Http\Controllers\Aldebaran;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Aldebaran\Sistema;
use App\Models\User;

class SistemaController extends Controller
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
            
            $sistema= Sistema::wherehas('empresa',function($query)use($user){
                                $query->where('empresas.id',$user->empresa_id);
                                if ($user->cliente){
                                    $query->wherehas('user', function($query)use($user){
                                        $query->where('users.id',$user->id);
                                    });
                                }
                            })
                            ->orderby('nombre','ASC')
                            ->paginate(15);

            return \Response::json(['status'=>0,'descripcion'=>'Listado de Sistema','data'=>$sistema]); 

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
            'nombre' => 'required|unique:sistemas',
            
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            $campos=$request->all();
           
            \DB::beginTransaction();
                $sistema=(new Sistema);
               
                $sistema->nombre = $campos['nombre'];
                $sistema->empresa = $campos['empresa'];
                $sistema->nota = $campos['nota'];
                $sistema->save();

                $user = Auth::user();
                $sistema->empresa()->attach($user->empresa_id);

            \DB::commit();

            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Sistema','Sistema Creado correctamente: ');
            
            return \Response::json(['status'=>0,'descripcion'=>'Sistema Creado correctamente','data'=>'']);
        } catch (\Throwable $th) {
            \DB::rollback();
            $log=LogController::guardar('Error Creación de Sistema','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Crear el Sistema ','message'=>$th->getMessage()]);
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
            'nombre' => 'required|unique:sistemas',
            
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            $campos=$request->all();
           
            \DB::beginTransaction();
                $sistema=Sistema::find($id);
                $sistema->update($campos);

            \DB::commit();

            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Sistema','Sistema Modificado correctamente: ');
            
            return \Response::json(['status'=>0,'descripcion'=>'Sistema Modificado correctamente','data'=>'']);
        } catch (\Throwable $th) {
            \DB::rollback();
            $log=LogController::guardar('Error Creación de Sistema','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Crear el Sistema ','message'=>$th->getMessage()]);
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
