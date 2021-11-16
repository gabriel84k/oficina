<?php
    function estado($e){
        switch ($e) {
            case 'Activo':
                return 1;
            
            case 'Inactivo':
                return 0;
                
        }
    }
    # [Personal Temporal] #
    function temporal($e){
        switch ($e) {
            case 'true':
                return true;
            
            case 'false':
                return false;
                
        }
    }
?>