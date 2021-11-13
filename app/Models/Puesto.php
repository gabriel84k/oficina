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
        'descripcion',
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
        public function sector(){

            return $this->belongsToMany(Sector::class,'spt')->withPivot('sector_id');
        }

    # [Funciones especificas del Modelo] #

        public static function combobox(){
            $puesto = Puesto::select('nombre','id')->get();
            return $puesto;
        }

}
