<?php

namespace App\Http\Controllers\Camus;
use App\Http\Controllers\Controller;

use App\Models\Camus\Ctacte;
use App\Models\Camus\Ctactedetalle;
use App\Models\Camus\Producto;
use App\Models\Camus\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CtacteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ctacte = Ctacte::with(['producto','detallepago'])->paginate(20);
        return \Response::json(['status'=>0,'descripcion'=>'Todas las Ctas Ctes','data'=>$ctacte]);
    }

    public function filtrado()
    {
        
        $campo = request()->get('msj');
        $cliente = request()->get('id');
        
        if ($campo == ''){
                $ctacte = Ctacte::with(['producto','detallepago'])
                                ->where('cliente_id',$cliente)
                                ->paginate(20);
        }else{
                $producto = Producto::select('id')
                                        ->where(function($query) use ($campo) {
                                            if (!is_numeric ($campo)){
                                                $query->where('Nombre','like', '%'.$campo.'%');
                                                $query->orwhere('Descripcion','like', '%'.$campo.'%');
                                            }
                                        })->get();
               
                $ctacte = Ctacte::with(['producto'])
                                ->with('detallepago')
                                ->where(function($query) use ($campo) {
                                    if (is_numeric ($campo)){
                                        $query->where('id',$campo);
                                    }
                                })
                                
                                ->whereIn('producto_id',$producto)
                                ->where('cliente_id',$cliente)
                                ->paginate(20);
        }
               
        return \Response::json(['status'=>0,'descripcion'=>'Todas las Ctas Ctes','data'=>$ctacte]);
    }
    public function filtradocliente(){
        $campo = request()->get('msj');
        $producto = request()->get('id');
        $operador = request()->get('operador');
        if ($campo == ''){

                $ctacte = Ctacte::select('cliente_id')
                                ->where(function($query) use ($producto) {
                                        $query->where('producto_id',$producto);
                                })->get();

                $Cliente = Cliente::with(['ctacte'=>function($query) use ($producto,$operador) {
                                            $query->where('producto_id',$producto);
                                            if ($operador != ''){
                                                $query->where('Resto',$operador,0);
                                            }
                                        }])
                                    ->whereIn('id',$ctacte)
                                    ->paginate(20);
        }else{
                

                $Cliente = Cliente:: with(['ctacte'=>function($query) use ($producto,$operador) {
                                        $query->where('producto_id',$producto);
                                        if ($operador != ''){
                                            $query->where('Resto',$operador,0);
                                        }
                                    }])
                                                             
                                    ->where(function($query) use ($campo) {
                                        $query->where('Nombre_Apellido','like', '%'.$campo.'%');
                                        $query->orwhere('Domicilio','like', '%'.$campo.'%');
                                        $query->orwhere('Dni', $campo);
                                        $query->orwhere('id',$campo);
                                    })
                                    ->paginate(20);
        }
                
        return \Response::json(['status'=>0,'descripcion'=>'Todas las Ctas Ctes','data'=>$Cliente]);
    }
    public function filtrobotones(){
        $operador = request()->get('operador');
        $campo = request()->get('msj');
        $cliente = request()->get('id');
        $producto = [];
        if ($operador != ''){

                if ($campo != ''){
                    $producto = Producto::select('id')
                                    ->where(function($query) use ($campo) {
                                        $query->where('Nombre','like', '%'.$campo.'%');
                                        $query->orwhere('Descripcion','like', '%'.$campo.'%');
                                        $query->orwhere('Nro_Producto', $campo);
                                    })->get();
                }
                $ctacte = Ctacte::with(['producto'])
                                ->with('detallepago')
                                ->where('Resto',$operador,0)
                                ->where(function($query) use ($producto,$campo) {
                                    if ($campo != ''){
                                        $query->whereIn('producto_id',$producto);
                                    }
                                })
                                ->where('cliente_id',$cliente)
                                ->paginate(20);
        }else{
            $ctacte = Ctacte::with(['producto'])
                                ->with('detallepago')
                                ->where('cliente_id',$cliente)
                                ->paginate(20);
        }
     
        return \Response::json(['status'=>0,'descripcion'=>'Todas las Ctas Ctes','data'=>$ctacte]);
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
                'cliente_id' => 'required',
                'producto_id' => 'required',
                'Cuotas' => 'required|numeric|max:255|gt:0',
                'Fecha_Compra' => 'required',
                'Total' => 'required|numeric|gt:0',
                'Entrega' => 'numeric',
                'MontoCuota' => 'numeric',
                'Financiacion' => 'required',
                'user_id' => 'required|numeric|min:0',
            ],[
                'cliente_id.required' =>'Debe Seleccionar un Cliente para asociar un producto!!',
                'producto_id.required' => 'Debe Seleccionar un Producto para poder asociar!!',
                'user_id.numeric' => 'Debe Seleccionar un Vendedor, Si no existe debe Crearlo!!',
                'user_id.required' =>'Debe Seleccionar un Vendedor, Si no existe debe Crearlo!!',
                'user_id.min' =>'Debe Seleccionar un Vendedor, Si no existe debe Crearlo!!',
            ]);
            if ($validator->fails()) {
                return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
            }
        try {
        
            $campos = $request->all();
            
            $ctacte = (new Ctacte);
            $campos['camus_cliente_id'] = $campos['cliente_id'];
            $campos['camus_producto_id'] = $campos['producto_id'];
            $campos['camus_user_id'] = $campos['user_id'];
            $ctacte->create($campos);
         
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Ctacte','Ctacte Creado correctamente: '. json_encode($ctacte));
            return \Response::json(['status'=>0,'descripcion'=>'Se guardo con exito','data'=>$ctacte]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Crear la ctacte ','message'=>$th->getMessage()]);
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
        
        $ctacte = Ctacte::with(['vendedor','cliente.cobrador'])->find($id);
        $ctactedetalle = $ctacte->detallepago()->with(['cobrador'])->orderby('id','Desc')->paginate(5);
        $ctacte->detallepago =$ctactedetalle ;
        
        
        return \Response::json(['status'=>0,'descripcion'=>'El detalle de la Cta Cte','data'=>$ctacte]);
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
                'Cuotas' => 'required|numeric|max:255|gt:0',
                'Fecha_Compra' => 'required',
                'Total' => 'required|numeric|gt:0',
                'Entrega' => 'numeric',
                'MontoCuota' => 'numeric',
                'Financiacion' => 'required',
                'cliente_id' => 'required',
                'producto_id' => 'required'
            ]);
            if ($validator->fails()) {
                return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
            }
        try {
        
            $campos = $request->all();
            
            $ctacteDetalle = Ctactedetalle::where('ctacte_id',$id)->sum('pago');
            $campos['Resto']=floatval($campos['Total'])-floatval($ctacteDetalle);
           
            $ctacte = Ctacte::find($id);
            $ctacte->update($campos);
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Modificar Ctacte','CtaCte Modificada correctamente: '. json_encode($ctacte));
            return \Response::json(['status'=>0,'descripcion'=>'Se Modifico con éxito','data'=>$ctacte]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Modificar la ctacte ','message'=>$th->getMessage()]);
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
