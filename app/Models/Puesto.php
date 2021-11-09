<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;
    protected $table =  'puestos';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nombre',
        'detalle',
        'estado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];
    # [ Relaciones ] #
    
        public function tarea()
        {
            return $this->belongsToMany(Tarea::class,'spt')->withPivot('tarea_id');
        }
        public function personal()
        {
            return $this->belongsToMany(Personal::class,'reds')->withPivot('personal_id');
        }
       


}
