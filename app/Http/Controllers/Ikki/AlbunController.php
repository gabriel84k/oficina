<?php

namespace App\Http\Controllers\Ikki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Ikki\Albun;

class AlbunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albun = Albun::all();
        return \Response::json(['status'=>200,'descripcion'=>'Todos los Albunes','data'=>$albun]); 
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
            'titulo' => 'required',
        ],[]); 
        
        if ($validator->fails()) {
            return \Response::json(['status'=>-1,'errors'=>$validator->errors(),'descripcion'=>'']);
        }   
        try {
            
            $campos = $request->all();
            $albun = (new Albun);
            $albun->titulo = $campos['titulo'];
            $albun->descripcion = $campos['descripcion'];
            $albun->save();
            
            return \Response::json(['status'=>0,'descripcion'=> 'Albun publicado con éxito','data'=>'']);
         } catch (\Exception $th) {
            //$log=(new logControllers)->error($th, 'Imagenes','store');

            return \Response::json(['status'=>-1,'descripcion'=>'Albun NO publicado '.$th->getMessage() ,'data'=>'','Line : '=>$th->getLine()]);
            
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
        $galeria = Albun::where('id',$id)
                        ->with('galeria')->paginate(20);
        foreach ($galeria as $key => $value) {
            $value->cantidad = count($value->galeria);

        }
        return \Response::json(['status'=>200,'descripcion'=>'Todas las fotos','data'=>$galeria]); 
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
