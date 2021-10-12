<?php

namespace App\Http\Controllers\Camus;
use App\Http\Controllers\Controller;

use App\Models\Camus\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producto = Producto::orderby('Nombre')->with(['ctacte','ctacte.cliente'])->paginate(20);
        return \Response::json(['status'=>0,'descripcion'=>'Todos los Clientes','data'=>$producto]);
    }
    public function comboproducto(){
        $producto = Producto::all();
        $estructure = [];
        foreach ($producto as $key => $value) {
            $estructure[$key] = ['text' => $value->Nombre,'value' => $value->id];
        }
        
        return json_encode($estructure);
    }

    public function filtrado(Request $request)
    {
        $campo = $request->get('msj');
        if ($campo == ''){
                $producto = Producto::with(['ctacte','ctacte.cliente'])->orderby('Nombre')->paginate(20);
        }else {
                $producto = Producto::with(['ctacte','ctacte.cliente'])
                            ->where('Nombre', 'like', '%'.$campo.'%')
                            ->orwhere('Descripcion','like','%'.$campo.'%')
                            ->orwhere('Nro_Producto','like',$campo)
                            ->orwhere('id',$campo)
                            ->orderby('Nombre')
                            ->paginate(10);
        }
        return \Response::json(['status'=>0,'descripcion'=>'Todos los Productos','data'=>$producto]);
        
    }
    public function filtradoConCliente(Request $request){
        $campo = $request->get('msj');
        $idcliente = $request->get('id');
        $Producto = Producto::with(['ctacte.cliente' => function($query) use ($idcliente) {
                                                            if($idcliente){
                                                                $query->where('cliente_id',$idcliente);
                                                            } 
                                                        }
                                    ,'ctacte.detallepago'])
                    ->where(function($query) use ($campo) {
                        if ($campo){
                            
                            $query->where('Nombre', 'like', '%'.$campo.'%');
                            $query->orwhere('Nro_Producto','like',$campo);
                            $query->orwhere('Descripcion','like','%'.$campo.'%');
                        }
                    })
                    ->orderby('Nombre')
                    ->get();
        foreach ($Producto as $key => $value) {
            if(count($value->ctacte) == 0){
                unset($Producto[$key]);
            }
        }
        return \Response::json(['status'=>0,'descripcion'=>'Todos los Productos','data'=>$Producto]);
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
            'Nombre' => 'required|max:255|unique:camus_productos',
            'Descripcion' => 'required|max:500',
            'Precio' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            $campos = $request->all();
            $producto = (new Producto);
            $producto->create($campos);
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Producto','Producto Creado correctamente: '. json_encode($producto));
            return \Response::json(['status'=>0,'descripcion'=>'Se guardo con exito','data'=>$producto]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Crear el Producto ','message'=>$th->getMessage()]);
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
        $Producto = Producto::with(['ctacte.cliente','ctacte.producto','ctacte.detallepago'])
                            ->find($id);
        return \Response::json(['status'=>0,'descripcion'=>'Se guardo con exito','data'=>$Producto]);                   
        
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
            'Nombre' => 'required|max:255',
            'Descripcion' => 'required|max:500',
            'Nro_Producto' => 'required|numeric',
            'Precio' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
           
            $campos = $request->all();
            $producto = Producto::find($id);
            $producto->update($campos);
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Modificar Producto','Producto Modificado correctamente: '. json_encode($producto));
            return \Response::json(['status'=>0,'descripcion'=>'Se Modificó con exito el producto','data'=>$producto]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al modificacr el Producto ','message'=>$th->getMessage()]);
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
