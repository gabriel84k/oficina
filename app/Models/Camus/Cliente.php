<?php

namespace App\Models\Camus;


use App\Models\Cliente as ClienteAioros;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends ClienteAioros
{
    use HasFactory;
    protected $table =  'camus_clientes';
    public $timestamps = true;
    protected $primaryKey = 'id';

    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
        'Nombre_Apellido', 
        'Domicilio', 
        'Localidad', 
        'Dni', 
        'Telefono', 
        'Celular', 
        'Observaciones',
        'dia',
        'Orden',
        'Estado',
        'camus_zona_id',
        'camus_user_id',
        'cliente_id'

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

    # [Relaciones] #
    public function ctacte()
    {
        return $this->hasMany(Ctacte::class,'camus_cliente_id','id');
    }
    public function zona(){
        return $this->hasOne(Zona::class,'id','camus_zona_id');
    }
    public function log()
    {
        return $this->hasMany(Log::class,'camus_user_id','id');
    }
    public function cobrador()
    {
        return $this->hasOne(User::class,'id','camus_user_id');
    }

    # [Relación al Modelo Padre] #
    public function clienteAioros()
    {
        return $this->hasOne(ClienteAioros::class,'id','cliente_id');
    }
}
