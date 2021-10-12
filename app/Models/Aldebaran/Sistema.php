<?php

namespace App\Models\Aldebaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class Sistema extends Model
{
    use HasFactory;
    protected $table =  'sistemas';
    public $timestamps = true;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 
        'empresa', 
        'nota'
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
    public function ticket()
    {
        return $this->hasMany(Ticket::class,'sistema_id','id')->orderBy('created_at','DESC');
    }
    public function empresa()
    {
        return $this->belongsToMany(Empresa::class,'empresa_sistemas')->withPivot('empresa_id');
    }
}
