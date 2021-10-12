<?php

namespace App\Http\Controllers\Camus;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Camus\Cliente;
use App\Models\Camus\Zona;
use App\Models\Camus\Ctacte;
use App\Models\Camus\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class PrintController extends Controller
{
    private $image;

    public function __construct(){
        $this->image = base64_encode(file_get_contents(public_path('/images/logo_recorte.jpeg')));
       
    }
    public function listadocliente(){
        PDF::setOptions(['isRemoteEnabled' => true, 'enable_javascript' => true]);
        $cliente = Cliente::with(['zona'=> function($query) {
                                    $query->with(['user'=> function($query) {
                                        $query->where('tipo_id',3);
                                    }]);
                                }])->orderby('Nombre_Apellido')->where('Estado','1')->get();
        
        $pdf = PDF::loadView('PDF.listadoCliente', ['items'=>$cliente])->setPaper('a4', 'portrait')->setWarnings(true);;

        return $pdf->stream('listadoCliente.pdf');
    }
    public function listadocobrador(){

        PDF::setOptions(['isRemoteEnabled' => true, 'enable_javascript' => true,'isPhpEnabled' => true ,'isHtml5ParserEnabled' => true,'chroot' => public_path()]);
        //$cobrador =User::with(['tipo','zona','zona.cliente'])->where('tipo_id',3)->get();
        
        $cobrador =User::with(['zona' => function($query) {
                            $query->with(['Cliente'=> function($query) {
                                $query->with(['ctacte'=> function($query) {
                                    $query->where('Resto','>',0);
                                    
                                    $query->with('vendedor');
                                    $query->with('producto'); 
                                    
                                }]);
                            }]);
                        }])->where('tipo_id',3)
                        ->get();

        $pdf = PDF::loadView('PDF.listadoCobrador', ['items' => $cobrador,'image' => $this->image])->setPaper('legal', 'landscape')->setWarnings(true);;

        //$pdf = PDF::loadView('PDF.listadoCobrador', ['items' => $cobrador,'image' => $this->image])->setPaper('legal', 'portrait')->setWarnings(true);;

        return $pdf->stream('listadoCobrador.pdf');
    }
    public function listadocobranza(){

        PDF::setOptions(['isRemoteEnabled' => true, 'enable_javascript' => true,'isPhpEnabled' => true ,'isHtml5ParserEnabled' => true,'chroot' => public_path()]);
       
        $cobranza =Zona::with(['cliente'=> function($query) {
                                    $query->with(['ctacte'=> function($query) {
                                        $query->where('Resto','>',0);
                                        
                                        $query->with('vendedor');
                                        $query->with('producto'); 
                                        
                                    }]);
                            }])
                            ->get();
       
        $pdf = PDF::loadView('PDF.listadoCobranza2', ['items' => $cobranza,'image' => $this->image])->setPaper('legal', 'landscape')->setWarnings(true);;

        return $pdf->stream('cobranza.pdf');
    }
    public function listadocxcobrador($id){

        PDF::setOptions(['isRemoteEnabled' => true, 'enable_javascript' => true,'isPhpEnabled' => true ,'isHtml5ParserEnabled' => true,'chroot' => public_path()]);
        $cobranza = User::where('tipo_id',3)
                        ->where(function($query) use ($id) {
                            if($id > 0){
                                $query->where('id',$id);
                            }
                        })
                        ->with(['zona'=> function($query) {
                            $query->with(['cliente'=> function($query) {
                                    $query->with(['ctacte'=> function($query) {
                                        $query->where('Resto','>',0);
                                        
                                        $query->with('vendedor');
                                        $query->with('producto'); 
                                        
                                    }]);
                            }]);
                        }])
                            ->get();
       
        $pdf = PDF::loadView('PDF.listadoCxCobrador', ['items' => $cobranza,'image' => $this->image])->setPaper('legal', 'landscape')->setWarnings(true);;

        return $pdf->stream('listadoCxCobrador.pdf');
    }
    public function listadorentabilidad($desde,$hasta){

        PDF::setOptions(['isRemoteEnabled' => true, 'enable_javascript' => true,'isPhpEnabled' => true ,'isHtml5ParserEnabled' => true,'chroot' => public_path()]);
        $rent =Ctacte::with(['detallepago'=> function($query) use ($desde,$hasta){
                                $query->wherebetween('Fecha',[$desde,$hasta]);
                            }])
                            ->get();
       
        $pdf = PDF::loadView('PDF.listadorentabilidad', ['items' => $rent,'image' => $this->image, 'fecha' => [$desde,$hasta]])->setPaper('a4', 'portrait')->setWarnings(true);;

        return $pdf->stream('listadorentabilidad.pdf');
    }
}
