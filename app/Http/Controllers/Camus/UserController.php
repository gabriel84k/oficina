<?php

namespace App\Http\Controllers\Camus;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Camus\User;
use App\Models\Camus\Tipo;
use App\Models\Camus\Zona;
use App\Models\Camus\Permiso;

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
            $isroot = Auth::user()->tipo_id;

            $users=User::with(['permisos','tipo','zona','userAioros']) ->orderby('name','ASC')->paginate(15)->makeVisible('email');
            return \Response::json(['status'=>0,'descripcion'=>'Listado de usuarios','data'=>$users, 'isroot'=>$isroot]); 

        } catch (\Throwable $th) {
            #hacer el log.
            return \Response::json(['status'=>-1,'descripcion'=>'Error en Listado','data'=>$th->getMessage()]); 
        }
    }
    public function filtrado(){
        try {
            $msj = request()->get('msj');
            
            $users=User::where(function($query) use ($msj){
                             if ( !is_numeric($msj) ){
                               
                                $query->where('name','like','%'.$msj.'%');
                                $query->orwhere('email','like','%'.$msj.'%');
                            }else{
                                $query->where('id','=',$msj);
                            }
                        })
                        ->orderby('name','ASC')
                        ->paginate(15);
            
            return \Response::json(['status'=>0,'descripcion'=>'Listado de usuarios','data'=>$users]); 

        } catch (\Throwable $th) {
            #hacer el log.
            return \Response::json(['status'=>-1,'descripcion'=>'Error en Listado','data'=>$th->getMessage()]); 
        }
    }
    public function  combovendedor(){
        
        $vendedor = User::select("name as text","id as value")
                            ->where('camus_tipo_id',2)
                            ->where('estado',1)->get();
        return $vendedor;
    }
    public function  combocobrador(){
        $zona_id = request()->get('zona');
        
        $cobrador = User::select("name","id")
                        ->where('camus_tipo_id',3)
                        ->wherehas('zona', function($query)use($zona_id){
                            if ($zona_id){
                                $query->where('zona_id',$zona_id);
                            }
                        })
                        ->where('estado',1)->get();
            
        return $cobrador;

    }
    public function  combotipo(){
        $combotipo = Tipo::select("nombre as text","id as value")
                        ->where('estado',1)->get();
            
        return $combotipo;

    }
    public function  combozona(){
        $combozona = Zona::select("nombre","id")->get();

        return $combozona; 
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
            'name' => 'required|max:18',
            'email' => 'required',
            'tipo_id' => 'required|numeric|max:7|gt:0',
            'zona' => 'required|array|min:1'
            
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            $campos=$request->all();
           
            \DB::beginTransaction();
                $user=(new User);
                
                $user->name=$campos['name'];
                $user->email=$campos['email'];
                $user->email_verified_at=now();
                if(isset($campos['password']) && $campos['password']!=''){
                    $user->password=Hash::make($campos['password']);
                }
                $user->estado=1;
                $user->tipo_id=$campos['tipo_id'];
                $user->remember_token=\Str::random(10);
                $user->created_at=now();
                $user->updated_at=now();
                $user->save();

                foreach ($campos['zona'] as $key => $item) {
                    $user->zona()->attach($item['id']);
                }
                

                $permisos=(new Permiso);
                $permisos->menu=json_encode($campos['permisos']['menu']);
                $permisos->cliente=json_encode($campos['permisos']['cliente']);
                $permisos->usuario=json_encode($campos['permisos']['usuario']);
                $permisos->producto=json_encode($campos['permisos']['producto']);
                $permisos->config=json_encode($campos['permisos']['config']);
                $permisos->reporte=json_encode($campos['permisos']['reporte']);
                $permisos->reporte=json_encode($campos['permisos']['reporte']);
                $permisos->user_id=$user->id;
                $permisos->save();
            \DB::commit();

            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Usuario','Usuario Creado correctamente: '. json_encode($user));
            
            return \Response::json(['status'=>0,'descripcion'=>'Usuario Creado correctamente','data'=>$user->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
            //$log=LogController::grabar('Error Creación de Usuario','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Crear el Usuario ','message'=>$th->getMessage()]);
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
            'name' => 'required|max:18',
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

                $user->zona()->detach();
                foreach ($campos['zona'] as $key => $item) {
                    $user->zona()->attach($item['id']);
                }

                $user->permisos->menu=$campos['permisos']['menu'];
                $user->permisos->cliente=$campos['permisos']['cliente'];
                $user->permisos->usuario=$campos['permisos']['usuario'];
                $user->permisos->producto=$campos['permisos']['producto'];
                $user->permisos->config=$campos['permisos']['config'];
                $user->permisos->reporte=$campos['permisos']['reporte'];
                $user->permisos->update();
            \DB::commit();
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Modificar Usuario','Usuario Modificado correctamente: '. json_encode($user));
           
            return \Response::json(['status'=>0,'descripcion'=>'Usuario Modificado Correctamente','data'=>'']);
        } catch (\Throwable $th) {
            \DB::rollback();
            //$log=LogController::grabar('Error Modificación de Usuario','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Modificado el Usuario','data'=>$th->getMessage(),'validator'=>$validator]);
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
