<?php

namespace App\Models\Camus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctactedetalle extends Model
{
    use HasFactory;
    protected $table =  'camus_ctactedetalles';
    public $timestamps = true;
    protected $primaryKey = 'id';

    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
        'Fecha', 
        'Pago', 
        'Detalle', 
        'camus_ctacte_id',
        'camus_user_id'
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
       return $this->hasOne(Ctacte::class,'id','camus_ctacte_id');
   }
   public function cobrador()
    {
        return $this->hasOne(User::class,'id','camus_user_id');
    }
}
