<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;
    protected $table =  'sectors';
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
        'empresa_id'
       
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
    
        public function empresa()
        {
            return $this->hasOne(Empresa::class,'id','empresa_id');
        }
        public function puesto()
        {
            return $this->belongsToMany(Puesto::class,'spt')->withPivot('puesto_id');
        }
       
    # [Funciones especificas del Modelo] #

        public static function combobox(){
            $sector = Sector::select('nombre','id')->get();
            return $sector;
        }
}
