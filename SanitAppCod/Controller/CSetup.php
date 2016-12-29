<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CSetup
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CSetup {

    public function impostaPagina() {
        
        $view = USingleton::getInstance('VSetup');
        $controller = $view->getController();
        switch ($controller)
        {
        case 'installa':
            
            
         
        break;
        default:
            $view->restituisciPaginaInstallazione();
        break;
        }
    }
    
}
