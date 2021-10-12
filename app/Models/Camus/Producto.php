<?php

namespace App\Models\Camus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table =  'camus_productos';
    public $timestamps = true;
    protected $primaryKey = 'id';

    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
        'Nombre', 'Descripcion', 'Nro_Producto', 'Precio', 'Estado'
    ];

   /**
    * Los atributos que deben ocultarse para las matrices.
    *
    * @var array
    */
    protected $hidden = [
        
    ];

   /**
    * Los atributos que se deben convertir a los tipos nativos.
    *
    * @var array
    */
    protected $casts = [
        
    ];


    public $columns = [
      
    ];


    public function ctacte()
    {
        return $this->hasMany(Ctacte::class);
    }
    
}
