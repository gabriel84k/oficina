<?php
namespace App\Http\Controllers\Funciones;

class Funciones{
    static function estado($e){
        switch ($e) {
            case 'Activo':
                return 1;
            
            case 'Inactivo':
                return 0;
                
        }
    }
}

?>