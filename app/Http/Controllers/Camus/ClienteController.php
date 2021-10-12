<?php

namespace App\Http\Controllers\Camus;
use App\Http\Controllers\Controller;

use DateTime;

use App\Models\Camus\Cliente;
use App\Models\Camus\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campo = request()->all();
        $user = Auth::user()->userCamus;
        
        if (!isset( $campo['orderby']) ){
            $campo['orderby'] = "Nombre_Apellido";
            $campo['ordenar'] = 'Asc';
        }
        $cliente = Cliente::select('*','camus_clientes.id as id')
                            ->with(['ctacte.producto','ctacte.detallepago','zona','cobrador','clienteAioros']) 
                            ->join('camus_zonas', 'camus_clientes.camus_zona_id', '=', 'camus_zonas.id')
                            ->where(function($query)use($user){
                                if ($user->tipo_id == 2 || $user->tipo_id == 3 ){
                                    $arr=[];
                                    foreach ($user->zona as $key => $value) {
                                        $arr[$key] = $value->id;
                                    }
                                    $query->whereIN('zona_id',$arr);
                                }
                            })
                            ->orderby($campo['orderby'],$campo['ordenar'])
                            ->paginate(10);
                       
        foreach ($cliente as $key => $cli) {
            $cli->Atrasado = false;

            foreach ($cli->ctacte as $key => $ctacte) {
                $fechaCompra =  new DateTime($ctacte->Fecha_Compra);
                $diff = $fechaCompra->diff(now());
                switch ($ctacte->Financiacion) {
                    case 'Semanal':
                        $ctacte->Normal_Cuotas = round($ctacte->Cuotas - ($diff->format('%a') / 7));
                        break;
                    case 'Mensual':
                        
                        $ctacte->Normal_Cuotas = round(($diff->format('%a') / 31) - $ctacte->Cuotas  );
                        break;
                    case 'Anual':
                        $ctacte->Normal_Cuotas = round($ctacte->Cuotas - ($diff->format('%a') / 365));
                        break;
                    default:
                        $ctacte->Normal_Cuotas = $ctacte->Resto_Cuotas;
                        break;
                }
                
                if (($ctacte->Resto_Cuotas > $ctacte->Normal_Cuotas) && ($ctacte->Resto_Cuotas > 0) ){
                    $cli->Atrasado = true;
                    $ctacte->Atrasado = true;

                    $ctacte->deudaCuota = $ctacte->Resto_Cuotas - $ctacte->Normal_Cuotas;
                    $ctacte->deudaMonto = $ctacte->Resto - ($ctacte->Resto - ($ctacte->deudaCuota * $ctacte->MontoCuota));
                }else{
                   
                    $ctacte->Atrasado = false;
                }
            }
        }
        return \Response::json(['status'=>0,'descripcion'=>'Todos los Clientes','data'=>$cliente]);

        
    }
    public function filtrado(Request $request)
    {
        
        $campo = $request->get('msj');
        $user = Auth::user();
       
        if ($campo == ''){
                $cliente = Cliente::select('*','camus_clientes.id as id')
                                    ->where(function($query)use($user){
                                        if ($user->tipo_id == 2 || $user->tipo_id == 3 ){
                                            $arr=[];
                                            foreach ($user->zona as $key => $value) {
                                                $arr[$key] = $value->id;
                                            }
                                            $query->whereIN('camus_zona_id',$arr);
                                        }
                                    })
                                    ->with(['ctacte.producto','ctacte.detallepago','zona','cobrador'])
                                    ->join('camus_zonas', 'camus_clientes.zona_id', '=', 'camus_zonas.id')
                                    ->orderby('Nombre_Apellido')
                                    ->paginate(20);
        }else {

                $cliente = Cliente::select('*','zonas.nombre as nombre','clientes.id as id')
                            ->with(['ctacte.producto','ctacte.detallepago','zona','cobrador'])
                            ->where(function($query)use($user){
                                if ($user->tipo_id == 2 || $user->tipo_id == 3 ){
                                    $arr=[];
                                    foreach ($user->zona as $key => $value) {
                                        $arr[$key] = $value->id;
                                    }
                                    $query->whereIN('camus_zona_id',$arr);
                                }
                            })
                            ->where('Nombre_Apellido', 'like', '%'.$campo.'%')
                            ->orwhere('dni',$campo)
                            //->orwhere('Domicilio','like','%'.$campo.'%')
                            ->join('camus_zonas', 'camus_clientes.camus_zona_id', '=', 'camus_zonas.id')
                            ->orwhere('Observaciones','like','%'.$campo.'%')
                            ->orwhere('camus_clientes.id',$campo)
                            ->orderby('Nombre_Apellido')
                            ->paginate(10);
                
               
        }
        foreach ($cliente as $key => $cli) {
            $cli->Atrasado = false;
            
            foreach ($cli->ctacte as $key => $ctacte) {
                $fechaCompra =  new DateTime($ctacte->Fecha_Compra);
                $diff = $fechaCompra->diff(now());
                switch ($ctacte->Financiacion) {
                    case 'Semanal':
                        $ctacte->Normal_Cuotas = round($ctacte->Cuotas - ($diff->format('%a') / 7));
                        break;
                    case 'Mensual':
                        $ctacte->Normal_Cuotas = round($ctacte->Cuotas - ($diff->format('%a') / 31));
                        break;
                    case 'Anual':
                        $ctacte->Normal_Cuotas = round($ctacte->Cuotas - ($diff->format('%a') / 365));
                        break;
                    default:
                        $ctacte->Normal_Cuotas = $ctacte->Resto_Cuotas;
                        break;
                }
                if ($ctacte->Resto_Cuotas > $ctacte->Normal_Cuotas){
                    $cli->Atrasado = true;
                    $ctacte->Atrasado = true;

                    $ctacte->deudaCuota = $ctacte->Resto_Cuotas - $ctacte->Normal_Cuotas;
                    $ctacte->deudaMonto = $ctacte->Resto - ($ctacte->Resto - ($ctacte->deudaCuota * $ctacte->MontoCuota));
                }else{
                   
                    $ctacte->Atrasado = false;
                }
            }
        }
        return \Response::json(['status'=>0,'descripcion'=>'Todos los Clientes','data'=>$cliente]);
        
    }
    public function filtradoConProducto(Request $request)
    {
        $campo = $request->get('msj');
        $idproducto = $request->get('id');
        $cliente = Cliente::with(['ctacte.producto' => function($query) use ($idproducto) {
                                                            if($idproducto){
                                                                $query->where('producto_id',$idproducto);
                                                            } 
                                                        }
                                    ,'ctacte.detallepago','zona'])
                    ->where(function($query) use ($campo) {
                        if ($campo){
                            $query->where('Nombre_Apellido', 'like', '%'.$campo.'%');
                            $query->orwhere('dni','like',$campo);
                            $query->orwhere('Domicilio','like','%'.$campo.'%');
                            $query->orwhere('Observaciones','like','%'.$campo.'%');
                        }
                    })
                    ->orderby('Nombre_Apellido')
                    ->get();
        foreach ($cliente as $key => $value) {
            if(count($value->ctacte) == 0){
                unset($cliente[$key]);
            }
        }
        return \Response::json(['status'=>0,'descripcion'=>'Todos los Clientes','data'=>$cliente]);
    }
    public function  combozona(){
        
        $zona = Zona::select("nombre as text","id as value","estado")->orderby('id','ASC')->where('estado',1)->get();
                  
        return $zona;
    }
    public function orden($zona){
        
        $cliente = Cliente::select(\DB::raw("CONCAT(camus_clientes.Nombre_Apellido,' - ',camus_clientes.orden) as text"),"id as value")
                                ->where('camus_zona_id',$zona)
                                ->orderby('Orden')->get();
        return $cliente;
        
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
                'Nombre_Apellido' => 'required|max:255',
                'Domicilio' => 'required|max:255',
                'Dni' => 'required|numeric|unique:camus_clientes',
                'zona_id' => 'required|numeric|min:1',
                'user_id' => 'required|numeric|min:1'
            
            ],[
                'user_id.min' => 'Debe Seleccionar un Cobrador, si no existe debe crearlo!!',
                'user_id.numeric' => 'Debe Seleccionar un Cobrador, si no existe debe crearlo!!',
                'user_id.required' =>'Debe Seleccionar un Cobrador, si no existe debe crearlo!!',
                'zona_id.min' => 'Debe Seleccionar una Zona!!',
                'zona_id.numeric' => 'Debe Seleccionar una Zona!!',
                'zona_id.required' =>'Debe Seleccionar una Zona!!'
            ]); 
            
            if ($validator->fails()) {
                return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
            }
        try {     
                
                $campos = $request->all();
                $cliente = Cliente::where('camus_zona_id',$campos['zona_id']);
                                    
                if ($campos['Orden'] != 0){
                    # Obtenemos el orden del cliente seleccionado para asignarlo al orden del nuevo cliente.
                   
                    $cli = $cliente->find($campos['Orden']);
                    $campos['Orden'] = $cli->Orden ;
                   
                    # Recorremos los clientes mayores y le sumamos uno, así corremos el orden uno mas. 
                    $cliente = Cliente::where('camus_zona_id',$campos['zona_id']);
                    $clisumaorden = $cliente->where('Orden','>=',$campos['Orden'])->get();
                    
                    foreach ($clisumaorden as $key => $value) {
                        $value->Orden = $value->Orden + 1;
                        $value->update();
                    }
                    
                }else{
                    $cliente = $cliente->get()->last();
                    
                    if($cliente){
                        $campos['Orden'] = $cliente->Orden + 1 ;
                    }else{
                        $campos['Orden'] = 1 ;
                    }
                }

                $cliente = (new Cliente);
                $campos['camus_zona_id'] = $campos['zona_id'];
                $campos['camus_user_id'] = $campos['user_id'];
                $cliente->create($campos);
                #-[Grabamos la actividad del usuario]-#
                    $log=LogController::guardar('Crear Cliente','Cliente Creado correctamente: '. json_encode($cliente));
                return \Response::json(['status'=>0,'descripcion'=>'Se Creo con éxito el Cliente','data'=>$cliente]);

        } catch (\Throwable $th) {
            
            return \Response::json(['status'=>-1,'descripcion'=>'Error al Crear el Cliente ','message'=>$th->getMessage()]);
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
        $cliente = Cliente::select('*','camus_clientes.id as id') 
                            ->join('camus_zonas', 'camus_clientes.camus_zona_id', '=', 'camus_zonas.id')
                            ->with(['ctacte.producto','ctacte.detallepago','zona']);

        if ($id <> 'undefined'){
            
            $cliente = $cliente->find($id);
            return \Response::json(['status'=>0,'descripcion'=>'El Cliente','data'=>$cliente]);
        }else{
            $cliente = $cliente->orderby('Nombre_Apellido')->paginate(10);
            return \Response::json(['status'=>0,'descripcion'=>'Todos los Clientes','data'=>$cliente]);
        }
        
    }

    public function showproductocliente($producto_id){

        $cliente = Cliente::with(['ctacte' => function($query) use ($producto_id) {
                                    $query->where('producto_id',$producto_id);
                                }])->get();
        foreach ($cliente as $key => $value) {
           
           if (count($value->ctacte) == 0){
                unset($cliente[$key]);
           }
        }
                                
        return \Response::json(['status'=>0,'descripcion'=>'El Cliente','data'=>$cliente]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
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
            'Nombre_Apellido' => 'required|max:255',
            'Domicilio' => 'required|max:255',
            'Dni' => 'required|numeric',
        
        ]); 
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        try {
            $campos = $request->all();
            $clienteupdate = Cliente::find($id);
            $cliente = Cliente::where('camus_zona_id',$campos['zona_id']);
                                    
            if ($campos['Orden'] != ''){
                # Obtenemos el orden del cliente seleccionado para asignarlo al orden del nuevo cliente.
                $cli = $cliente->find($campos['Orden']);
                if($cli){
                    $campos['Orden'] = $cli->Orden ;
                   
               
                    # Recorremos los clientes mayores y le sumamos uno, así corremos el orden uno mas. 
                    $cliente = Cliente::where('camus_zona_id',$campos['zona_id']);
                
                    if ($clienteupdate->Orden < $cli->Orden){
                        $OrdenMayor = $cli->Orden;
                        $OrdenMenor = $clienteupdate->Orden; 
                        $operacion = '+';
                    }else{
                        $OrdenMayor = $clienteupdate->Orden;
                        $OrdenMenor = $cli->Orden;
                        $operacion = '-';
                    }
                    $clisumaorden = $cliente->where('Orden','>=',$OrdenMenor)
                                            ->where('Orden','<=',$OrdenMayor)
                                            ->get();
                    
                    foreach ($clisumaorden as $key => $value) {
                        if ($operacion == '+')
                            $value->Orden = $value->Orden - 1;
                        else{
                            $value->Orden = $value->Orden + 1;
                        }
                        $value->update();
                    }
                }else{
                    $campos['Orden'] = 1;
                    
                }
                
            }else{
                $cliente = $cliente->get()->last();
               
                if($cliente){
                    $campos['Orden'] = $cliente->Orden + 1 ;
                }else{
                    $campos['Orden'] = 1 ;
                }
            }

           
            $clienteupdate->update($campos);
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Modificar Cliente ','Cliente Modificado  correctamente: '. json_encode($cliente));
            return \Response::json(['status'=>0,'descripcion'=>'Se Modifico con éxito','data'=>$cliente]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al Modificar el Cliente ','linea:'=>$th->getLine(),'message'=>$th->getMessage()]);
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
