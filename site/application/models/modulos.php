<?php

class Modulos extends CI_Model{

    public function modulos($desativar = array()){
        $modulos = array(
            'menu',
            'home',
            'service',
            'portifolio',
            'about',
            'client',
            'price',
            'newsletter',
            'contact',
        );
        if($desativar){
            if(is_array($desativar)){
                foreach($desativar as $disable){
                    $key = array_search($disable,$modulos);
                    unset($modulos[$key]);
                    
                }
            }
        }
        return $modulos;

    }

}


?>