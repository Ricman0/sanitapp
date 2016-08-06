<?php

/**
 * Description of CmySanitApp
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */

class CmySanitApp {
    
    public function impostaPaginaMySanitApp()
    {
        $vMySanitApp= USingleton::getInstance('VmySanitApp');
        $task= $vMySanitApp->getTask();
        switch ($task) 
        {
            
            case 'prenotazioni':
                // si è richiesto tutte le prenotazioni relative ad un utente o associate ad un medico
                $fPrenotazioni = USingleton::getInstance('FPrenotazione');
            
            case 'referti':
                
            
            case 'impostazioni':
                

            default:
                 
                break;
        }
    }
}
