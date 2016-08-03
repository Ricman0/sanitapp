<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CAutenticazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CAutenticazione {
    
    /**
     * Metodo che permette di controllare se è stato effettuato il login
     * 
     * @access public
     * @param USession $session la sessione 
     * @return boolean true se è stato effettuato il login,
     *                 false altrimenti
     */
    public function logIn($session) 
    {
        $logIn = $session->checkVariabileSessione("loggedIn");       
        return $logIn;
    }
    
    /**
     * Metodo che consente di controllare se sono già stati inviati i dati per il login
     * 
     * @access private
     * @return boolean ritorna true se i dati per il log in sono già stati inviati
     *                         false altrimenti
     */
    private function datiInviati() 
    {
        
        if(!empty($_POST['username']) && !empty($_POST['password']))
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    
    
    public function impostaPaginaAutenticazione()
    {
        $vAutenticazione =  USingleton::getInstance('VAutenticazione');
        $task= $vAutenticazione->getTask();
        switch ($task)
        {
            case 'logIn':
            
                break;
            default: 
                break;
        }
    }
}
