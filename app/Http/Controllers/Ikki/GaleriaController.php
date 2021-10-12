<?php

namespace App\Http\Controllers\Ikki;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\Upload;
use Illuminate\Http\Request;

use App\Models\Ikki\Galeria;
use App\Models\Ikki\Albun;
class GaleriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galeria = Albun::with('galeria')->paginate(20);
        foreach ($galeria as $key => $value) {
            $value->cantidad = count($value->galeria);

        }
        return \Response::json(['status'=>200,'descripcion'=>'Todas las fotos','data'=>$galeria]); 
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
        
        try {
            
            $file = $request->file();
            $albun = $request->get('albun');
            foreach ($file as $key => $value) {
                # code...
                //obtenemos el nombre del archivo
                $nombre = $value->getClientOriginalName();
                
                
                $up = new upload($_FILES[$key]);
            
                if($up->processed){
                        $up->file_overwrite = true;
                        $up->file_auto_rename = false;
                        $up->image_resize = false;
                        //$up->image_x = $up->image_src_x/2;
                        //$up->image_ratio_y = true;
                        $up->jpeg_quality = 0;
                    
                }
                
                $up->file_new_name_body = pathinfo($nombre, PATHINFO_FILENAME);
                if($up->uploaded){
                    $up->Process(\Storage::disk('galeria')->getDriver()->getAdapter()->getPathPrefix());
                }

                # [Guardamos en la base de datos en el albun correspondiente] #
                $img = (new Galeria);
                $img->nombre = $nombre;
                $img->ext = pathinfo($nombre, PATHINFO_EXTENSION);
                $img->save();
                $img->albun()->attach($albun);
            }
           
            return \Response::json(['status'=>0,'descripcion'=> 'Imagenen publicada con éxito','data'=>'']);
        } catch (\Exception $th) {
        //$log=(new logControllers)->error($th, 'Imagenes','store');

        return \Response::json(['status'=>-1,'descripcion'=>'Imagenen NO publicada '.$th->getMessage() ,'data'=>'','Line : '=>$th->getLine()]);
        
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
}
