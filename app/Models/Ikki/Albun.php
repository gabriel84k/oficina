<?php

namespace App\Models\Ikki;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Albun extends Model
{
    use HasFactory;
    protected $table =  'ikki_albunes';
    public $timestamps = false;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'descripcion', 
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

    # [Relaciones] #
    
    public function galeria()
    {
        return $this->belongsToMany(Galeria::class,'ikki_albunes_galerias')->withPivot('galeria_id');
    }
   
   
}
