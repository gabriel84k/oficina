<?php

namespace App\Http\Controllers\Aldebaran;


use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Funciones\Upload;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Aldebaran\Sistema;
use App\Models\Aldebaran\TicketDetalle;
use App\Models\Aldebaran\Ticket;
use App\Models\Aldebaran\Foto;


class TicketController extends Controller
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
            
            if ($user->cliente){
                $cliente = $user->cliente->toArray('id');
            }else{
                $cliente = User::select('cliente_id')
                                ->where('empresa_id',$user->empresa_id)
                                ->has('cliente')
                                ->get()->toArray('cliente_id');
                
            }
          
            $Tikets = Ticket::whereIn('cliente_id',$cliente)
                                ->with(['detalleticket' => function($query){
                                    $query->with('foto');
                                    $query->with('tecnico');
                                }])
                                ->with(['cliente','sistema'])
                                ->orderby('created_at','DESC')
                                ->paginate(15);

            
                            
            return \Response::json(['status'=>0,'descripcion'=>'Listado de Tickets','data'=>$Tikets, 'isTipo'=>$user->tipo_id]); 

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
            'prioridad' => 'required|array|min:1',
            'sistema' => 'required|array|min:1',
            'ticket_detalle' => 'required|array|min:1',
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            $campos=$request->all();
            
            \DB::beginTransaction();
                $user = Auth::user();

                $ticket=(new Ticket);
                $ticket->estado = $campos['estado'];
                $ticket->nota = $campos['nota'];
                $ticket->prioridad = $campos['prioridad']['id'];
                if($user->cliente){
                    $ticket->cliente_id = $user->cliente->id;
                }
                
                $ticket->sistema_id = $campos['sistema']['id'];
                $ticket->save();

                $ticketDetalle=(new TicketDetalle);
                $ticketDetalle->tipo = 0;
                $ticketDetalle->titulo = $campos['ticket_detalle']['titulo'];
                $ticketDetalle->detalle = $campos['ticket_detalle']['detalle'];
                $ticketDetalle->tikect_id = $ticket->id;
                $ticketDetalle->save();
                
            \DB::commit();

            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Ticket','Ticket Creado correctamente: '. json_encode($user));
            
            return \Response::json(['status'=>0,'descripcion'=>'Ticket Creado correctamente','data'=>$user->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
            $log=LogController::guardar('Error Creación de Usuario','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Crear el Ticket ','message'=>$th->getMessage()]);
        }
        
    }
    public function storeDetalleTicket(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'detalle' => 'required|max:250',
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            
            $campos=$request->all();
            
            \DB::beginTransaction();
                $user = Auth::user();

                $ticketDetalle=(new TicketDetalle);
                $ticketDetalle->tipo = $campos['tipo'];
                $ticketDetalle->titulo = $campos['titulo'];
                $ticketDetalle->detalle = $campos['detalle'];
                $ticketDetalle->tikect_id = $id;
                if($user->tipo_id != 2 ){
                    $ticketDetalle->user_id = $user->id;
                }
                
                $ticketDetalle->save();
                
                $file = $request->file();
                
                //obtenemos el nombre del archivo
                foreach ($file as $key => $item) {
                  foreach ($item as $key => $value) {
                    $nombre = $value->getClientOriginalName();
                    //\Storage::disk('compartido')->put($nombre,  \File::get($value));   #- Este se usa para un hosting compartido
                    # [Disminuir tamaño imagen] #
                    $up = new upload($value);

                    if($up->processed){
                        if($up->file_src_size >= 530000){
                            $up->image_resize = true;
                            //$up->image_x = $up->image_src_x/2;
                            //$up->image_ratio_y = true;
                            $up->jpeg_quality = 75;
                        }
                    }
                    
                    
                    if($up->uploaded){
                        $up->Process(base_path().'/public/images/ticket');
                    }
                    
                    //rename($up->file_dst_pathname,base_path().'/public/images/ticket/'.$nombre);
                    
                    # [Grabar Foto en Base de datos] #
                    $foto = (new Foto);
                    $foto->nombre = $up->file_dst_name; //$nombre nombre original
                    $foto->aldebaran_ticket_detalle_id = $ticketDetalle->id;
                    $foto->save();
                  }
                }
    
            \DB::commit();

            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Ticket','Detalle Creado correctamente: '. json_encode($ticketDetalle));
            
            return \Response::json(['status'=>0,'descripcion'=>'Detalle Creado correctamente','data'=>$ticketDetalle->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
            $log=LogController::guardar('Error Creación del Detalle Ticket','Error: '.$th->getMessage().' - Linea: '.$th->getLine().' Controlador: UserController');
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Crear el Detalle Ticket ','Linea: '=> $th->getLine(),'message'=>$th->getMessage()]);
        }
        
    }
    public function storeTicket(Request $request, $id){
        
        try {
            $campos=$request->all();
            
            \DB::beginTransaction();

                $ticket=Ticket::where('id',$id)->first();
                $ticket->estado = $campos['estado'];
                $ticket->prioridad = $campos['prioridad'];
                $ticket->update();

                \DB::commit();
            return \Response::json(['status'=>0,'descripcion'=>'Ticket Modificado Correctamente','data'=>$ticket->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Modificar ','message'=>$th->getMessage()]);
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

    public function filtrado(){
        try {
            
            $user = Auth::user();
            $campos = request()->all();
            if ($user->cliente){
                $cliente = [$user->cliente->id];
            }else{
                $cliente = User::select('cliente_id')
                                ->where('empresa_id',$user->empresa_id)
                                ->has('cliente')
                                ->get()->toArray('cliente_id');
                
            }
            
            $Tikets = Ticket::whereIn('cliente_id',$cliente)
                                ->with(['detalleticket.tecnico','sistema'])
                                ->where('nota','like','%'.$campos['msj'].'%')
                                ->orderby('created_at','DESC')
                                ->paginate(15);
           
                            
            return \Response::json(['status'=>0,'descripcion'=>'Listado de Tickets','data'=>$Tikets, 'isTipo'=>$user->tipo_id]); 

        } catch (\Throwable $th) {
            #hacer el log.
            return \Response::json(['status'=>-1,'descripcion'=>'Error en Listado','data'=>$th->getMessage()]); 
        }
    }
    public function filtradoBoton(){
        try {
            
            $user = Auth::user();
            $campos = request()->all();
            if ($user->cliente){
                $cliente = $user->cliente->toArray('id');
            }else{
                $cliente = User::select('cliente_id')
                                ->where('empresa_id',$user->empresa_id)
                                ->has('cliente')
                                ->get()->toArray('cliente_id');
                
            }
            if($campos['tipo'] == 9){
                $filtro = '<>';
            }else{
                $filtro = '=';
            }
            $Tikets = Ticket::where('estado',$filtro,$campos['tipo'])
                                ->whereIn('cliente_id',$cliente)
                                ->with('detalleticket','cliente','sistema')
                                ->orderby('created_at','DESC')
                                ->paginate(15);
           
                            
            return \Response::json(['status'=>0,'descripcion'=>'Listado de Tickets','data'=>$Tikets, 'isTipo'=>$user->tipo_id]); 

        } catch (\Throwable $th) {
            #hacer el log.
            return \Response::json(['status'=>-1,'descripcion'=>'Error en Listado','data'=>$th->getMessage()]); 
        }
    }
}
