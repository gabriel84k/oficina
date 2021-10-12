<?php

namespace App\Http\Controllers;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Log::with('usuario')->paginate(20);
        return \Response::json(['status'=>0,'descripcion'=>'','data'=>$logs]);
    }
    public function filtrado()
    {
        try {
            $msj = request()->get('msj');
            $fdesde = request()->get('fdesde');
            $fhasta = request()->get('fhasta');
        
            $users=Log::where(function($query) use ($msj,$fdesde,$fhasta){
                            $query->wherebetween('created_at',[$fdesde,$fhasta]);
                            $query->where(function($query) use ($msj){
                                if ( !is_numeric($msj) ){
                                
                                    
                                    $query->orwherehas('usuario',function($query) use ($msj){
                                    
                                        $query->where('name','like','%'.$msj.'%');
                                    });
                                    $query->orwhere('detalle','like','%'.$msj.'%');
                                }else{
                                    $query->where('user_id','=',$msj);
                                }
                            });
                        })
                        ->with('usuario')
                        ->orderby('created_at','ASC')
                        ->paginate(20);
            
            return \Response::json(['status'=>0,'descripcion'=>'Listado de usuarios','data'=>$users]); 

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
    static function guardar($tipo,$detalle){
        $user=Auth::user();
        $log=(new Log);
        $log->detalle=$detalle;
        $log->tipo=$tipo;
        $log->user_id=$user->id;
        $log->save();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $log=(new Log);
        $log->detalle=$request->get('detalle');
        $log->tipo=$request->get('tipo');
        $log->user_id=$user->id;
        $log->save();
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
