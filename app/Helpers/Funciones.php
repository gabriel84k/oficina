<?php
    function estado($e){
        switch ($e) {
            case 'Activo':
                return 1;
            
            case 'Inactivo':
                return 0;
                
        }
    }
?>