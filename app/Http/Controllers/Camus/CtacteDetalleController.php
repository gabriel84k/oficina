<?php

namespace App\Http\Controllers\Camus;
use App\Http\Controllers\Controller;

use App\Models\Camus\Ctacte;
use App\Models\Camus\Ctactedetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CtacteDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ctactedetalle = Ctactedetalle::paginate(20);
        return \Response::json(['status'=>0,'descripcion'=>'Todo el detalle de las Ctas Ctes','data'=>$ctactedetalle]);
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
            'Fecha' => 'required',
            'Pago' => 'required|numeric',
            'ctacte_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        
        try {
            \DB::beginTransaction();
                $campos = $request->all();
                //$campos['user_id'] = Auth::user()->id; /* aqui se agrega para que el pago tenga un usuario lo que corresponde es que sea el vendedor pero lo quieren asi */
                
                $ctactedetalle = (new Ctactedetalle);
                $campos['camus_ctacte_id'] = $campos['ctacte_id'];
                $campos['camus_user_id'] = $campos['user_id'];
                $ctactedetalle->create($campos);

                $ctacte = Ctacte::find($campos['ctacte_id']);
                $ctacte->Resto = floatval($ctacte->Resto) - floatval($campos['Pago']);
                $ctacte->Porcentaje =100- (floatval($ctacte->Resto)*100)/floatval($ctacte->Total);
                $ctacte->Resto_Cuotas = (floatval($ctacte->Resto)*$ctacte->Cuotas)/floatval($ctacte->Total);
                $ctacte->update();
                
            \DB::commit();
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Detalle Ctacte','Detalle Ctacte Creado correctamente: '. json_encode($campos));
            return \Response::json(['status'=>0,'descripcion'=>'Se guardo el pago de $'. floatval($campos['Pago']) .' con exito, restan del producto : $'.$ctacte->Resto  ,'data'=>$ctactedetalle]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al generar el pago','message'=>$th->getMessage()]);
        }
    }
    public function storePagoRapido(Request $request, $id_cobrador)
    {
       
        try {
            \DB::beginTransaction();
                $campos = $request->all();
                //$campos['user_id'] = Auth::user()->id; /* aqui se agrega para que el pago tenga un usuario lo que corresponde es que sea el vendedor pero lo quieren asi */
                foreach ($campos as $key => $item) {
                    
                    $ctactedetalle = (new Ctactedetalle);
                    $item['camus_ctacte_id'] = $item['ctacte_id'];
                    $item['camus_user_id'] = $id_cobrador;
                    $ctactedetalle->create($item);

                    $ctacte = Ctacte::find($item['ctacte_id']);
                    $ctacte->Resto = floatval($ctacte->Resto) - floatval($item['Pago']);
                    $ctacte->Porcentaje =100- (floatval($ctacte->Resto)*100)/floatval($ctacte->Total);
                    $ctacte->Resto_Cuotas = (floatval($ctacte->Resto)*$ctacte->Cuotas)/floatval($ctacte->Total);
                    $ctacte->update();
                }
                
                
            \DB::commit();
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Detalle Ctacte','Detalle Ctacte Creado correctamente: '. json_encode($item));
            return \Response::json(['status'=>0,'descripcion'=>'Se guardo el pago de $'. floatval($item['Pago']) .' con exito, restan del producto : $'.$ctacte->Resto  ,'data'=>$ctactedetalle]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al generar el pago','message'=>$th->getMessage(), 'Linea: '=>$th->getLine()]);
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
        $ctactedetalle = Ctactedetalle::find($id);
        return \Response::json(['status'=>0,'descripcion'=>'El detalle de la Cta Cte','data'=>$ctactedetalle]);
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
            'Fecha' => 'required',
            'Pago' => 'required|numeric',
            'camus_ctacte_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }
        
        try {
            \DB::beginTransaction();
                $campos = $request->all();
                //$campos['user_id'] = Auth::user()->id; /* aqui se agrega para que el pago tenga un usuario lo que corresponde es que sea el vendedor pero lo quieren asi */
                
                $ctactedetalle = Ctactedetalle::find($campos['id']);
                $ctactedetalle->update($campos);

                $Totalctactedetalle = Ctactedetalle::where('camus_ctacte_id',$campos['camus_ctacte_id'])->sum('pago');

                $ctacte = Ctacte::find($campos['camus_ctacte_id']);
                $ctacte->Resto = floatval($ctacte->Total) - floatval($Totalctactedetalle);
                $ctacte->Porcentaje =100- (floatval($ctacte->Resto)*100)/floatval($ctacte->Total);
                $ctacte->Resto_Cuotas = (floatval($ctacte->Resto)*$ctacte->Cuotas)/floatval($ctacte->Total);
                $ctacte->update();
                
            \DB::commit();
            #-[Grabamos la actividad del usuario]-#
                $log=LogController::guardar('Nuevo Detalle Ctacte','Detalle Ctacte Creado correctamente: '. json_encode($campos));
            return \Response::json(['status'=>0,'descripcion'=>'Se guardo el pago de $'. floatval($campos['Pago']) .' con exito, restan del producto : $'.$ctacte->Resto  ,'data'=>$ctactedetalle]);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'errors'=>'','descripcion'=>'Error al generar el pago','message'=>$th->getMessage()]);
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
