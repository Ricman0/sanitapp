<?php

/**
 * Description of CmySanitApp
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */

class CmySanitApp {
    
    /**
     * Metodo che consente di impostare la pagina personale di qualsiasi user
     */
    public function impostaPaginaPersonale() 
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        // se username è impostato
        if(isset($username))
        {
            //bisogna capire il tipo di user
            $tipo = $sessione->leggiVariabileSessione('tipoUser');
            $vMySanitApp = USingleton::getInstance('VmySanitApp');
            $vMySanitApp->impostaPaginaPersonale($tipo);
        }
        else
        {
            // posso usare un metodo di VAutenticazione o devo inserire lo stesso metodo in VMySanitApp
            // forse è più giusto inserire il metodo in VMySanitApp in maniera da lasciare separati
            // i due casi d'uso.
            $vAutenticazione = USingleton::getInstance('VAutenticazione');
            $vAutenticazione->impostaPaginaLogIn();
        }
    }
    
    
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
