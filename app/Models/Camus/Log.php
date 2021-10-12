<?php

namespace App\Models\Camus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table =  'camus_logs';
    public $timestamps = true;
    protected $primaryKey = 'id';

    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
        'id', 
        'detalle', 
        'tipo',
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
    public function usuario()
    {
        return $this->hasOne(User::class,'id','camus_user_id');
    }
    
}
