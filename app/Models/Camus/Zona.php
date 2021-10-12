<?php

namespace App\Models\Camus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;
    protected $table =  'camus_zonas';
    public $timestamps = false;
    protected $primaryKey = 'id';

    /**fa
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
        'id', 'nombre', 'dia'
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
    # [Relaciones] 
    public function Cliente()
    {
        return $this->hasMany(Cliente::class,'camus_zona_id','id');
    }
    public function user()
    {
        return $this->belongsToMany(User::class,'camus_users_zonas')->withPivot('user_id');
    }
}
