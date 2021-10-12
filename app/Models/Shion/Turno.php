<?php

namespace App\Models\Shion;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'shion_turnos';
    # Claves primarias
        protected $primaryKey = 'id';
        public $incrementing = true;
        //protected $keyType = 'integer';
    protected $fillable = [
       
    ];
    # Marcas de tiempo
        public $timestamps = true;
        //protected $dateFormat = 'U';
        const CREATED_AT = 'created_at';
        const UPDATED_AT = 'updated_at';
    
    # Conexión de base de datos
     //protected $connection = 'connection-name';

    # Valores de atributo predeterminados
        protected $attributes = [
            
        ];

    # Asignacion Masiva
        //protected $fillable = ['name'];

    # Atributos de protección
        protected $guarded = [];

    #[Relaciones >>>]
    
    public function Cliente()
    {
        return $this->hasOne(Cliente::class,'id','cliente_id');
        
    }
    public function Usuario()
    {
        return $this->hasOne(User::class,'id','user_id');
        
    }
    
}
