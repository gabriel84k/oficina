<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Log;
use App\Models\User;
use App\Models\Tipo;
use App\Models\Cliente;
use App\Models\Permiso;

class UserController extends Controller
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

            $users=User::with(['permisos.permisoscamus', 'tipo'])
                        ->whereIN('tipo_id',[1,3])
                        ->where('empresa_id',$user->empresa_id)
                        ->orderby('name','ASC')
                        ->paginate(15);

            return \Response::json(['status'=>0,'descripcion'=>'Listado de usuarios','data'=>$users, 'isTipo'=>$user->tipo_id]); 

        } catch (\Throwable $th) {
            #hacer el log.
            return \Response::json(['status'=>-1,'descripcion'=>'Error en Listado','data'=>$th->getMessage()]); 
        }
    }
    public function  combotipo(){
        $combotipo = Tipo::select("nombre as text","id as value")
                        ->get();
            
        return $combotipo;
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
            'name' => 'required|max:30',
            'email' => 'required',
            'tipo_id' => 'required|numeric|max:7|gt:0',
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            $campos=$request->all();
           
            \DB::beginTransaction();
                
                if ($campos['cliente']){
                    $cliente = (new Cliente);
                    $cliente = $cliente->create($campos['cliente']);
                }
            
                $user=(new User);
                
                $user->name = $campos['name'];
                $user->email = $campos['email'];
                $user->email_verified_at = now();
                if(isset($campos['password']) && $campos['password']!=''){
                    $user->password=Hash::make($campos['password']);
                }
                $user->estado = 1;
                $user->tipo_id = $campos['tipo_id'];
                $user->remember_token = \Str::random(10);
                
                $user->empresa_id = Auth::user()->empresa_id;
                if ($campos['cliente']){
                    $user->cliente_id = $cliente->id;
                }
                $user->created_at = now();
                $user->updated_at = now();
                
                $user->save();
               
                #-[Creamos los permiso ]-#
                $permisos = Permiso::crear($user,$campos['permisos']);
                
            \DB::commit();

            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Usuario','Usuario Creado correctamente: '. json_encode($user));
            
            return \Response::json(['status'=>0,'descripcion'=>'Usuario Creado correctamente','data'=>$user->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
            $log=LogController::guardar('Error Creación de Usuario','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Crear el Usuario ','message'=>$th->getMessage(),'Linea: '=>$th->getLine()]);
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
            'name' => 'required|max:8',
            'email' => 'required',
        
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
           
            $campos=$request->all();

            $campo['password']=Hash::make($campos['password']);
           
            \DB::beginTransaction();
                $user=User::find($id);
                
                $user->name=$campos['name'];
                $user->email=$campos['email'];
                $user->email_verified_at=now();
                if(isset($campos['password']) && $campos['password']!=''){
                    $user->password=Hash::make($campos['password']);
                }
                $user->estado=1;
                $user->remember_token=\Str::random(10);
                $user->created_at=now();
                $user->updated_at=now();
                $user->update();
                
                $user->permisos->actualizar($user,$campos['permisos']);
                
            \DB::commit();
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Modificar Usuario','Usuario Modificado correctamente: '. json_encode($user));
           
            return \Response::json(['status'=>0,'descripcion'=>'Usuario Modificado Correctamente','data'=>'']);
        } catch (\Throwable $th) {
            \DB::rollback();
            //$log=LogController::grabar('Error Modificación de Usuario','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Modificado el Usuario','data'=>$th->getMessage(),'linea' => $th->getLine(),'validator'=>$validator]);
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
            $user=User::find($id);
            $user->estado=1;
            $user->updated_at=now();
            $user->update();
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::grabar('Eliminación Lógica de Usuario',$user);
            #-[Fin]-#
            return \Response::json(['status'=>0,'descripcion'=>'Usuario Eliminado Correctamente','data'=>'']);
        } catch (\Throwable $th) {
            $log=LogController::grabar('Error Eliminación de Usuario','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Eliminado el Usuario','data'=>$th->getMessage(),'validator'=>$validator]);
        }
    }

    #-------------------------------------------------------------------------------------------------#

     /**
     * Carga Imagenes
     *
     * @return \Illuminate\Http\Response
     */
    public function avatar(Request $request){
        
        try {
           
            $file = $request->file('avatar');

            //obtenemos el nombre del archivo
            
            $nombre = $request->id.'.'.$request->file('avatar')->extension();
            
            //indicamos que queremos guardar un nuevo archivo en el disco local
            //\Storage::disk('public')->put($nombre,  \File::get($file)); #- Este es para hosting dedicado un VPS
            \Storage::disk('compartido')->put($nombre,  \File::get($file));   #- Este se usa para un hosting compartido
            
            return \Response::json(['status'=>0,'descripcion'=> 'Imagenen Cargada con éxito','data'=>$nombre]);
         } catch (\Exception $th) {
            //$log=(new logControllers)->error($th, 'Imagenes','store');
            return \Response::json(['status'=>-1,'descripcion'=>'Imagenen NO Cargada '.$th->getMessage() ,'data'=>'']);
            
         }
    }
}
