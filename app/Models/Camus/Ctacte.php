<?php

namespace App\Models\Camus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctacte extends Model
{
    use HasFactory;
   
    protected $table =  'camus_ctactes';
    public $timestamps = true;
    protected $primaryKey = 'id';

    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
        'Fecha_Compra', 
        'Total', 
        'Resto', 
        'Resto_Cuotas',
        'Cuotas', 
        'Financiacion', 
        'Entrega',
        'MontoCuota',
        'Porcentaje', 
        'camus_producto_id', 
        'camus_cliente_id',
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


    public function producto()
    {
        return $this->hasOne(Producto::class,'id','camus_producto_id');
    }
    
    public function cliente()
    {
        return $this->hasOne(Cliente::class,'id','camus_cliente_id');
    }

    public function detallepago()
    {
        return $this->hasMany(Ctactedetalle::class,'camus_ctacte_id','id');
    }
    public function vendedor()
    {
        return $this->hasOne(User::class,'id','camus_user_id');
    }
    
}
