<?php

/**
 * Description of CConferma
 * Controller che si occupa di gestire la conferma degli account
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */

class CConferma {
    
    /**
     * Metodo che consente la conferma di un account
     * 
     * @access public
     * @return boolean TRUE conferma eseguita con successo, FALSE altrimenti.
     */
    public function confermaUser() 
    {
        switch ($this->getUser())
                {
                    case 'utente':
                        $username = $this->getUsername();
                        $fUtente = USingleton::getInstance('FUtente');
                        return $fUtente->confermaUser($this->getUsername());
//                        break;
                    
                    case 'medico':
                        $username = $this->getUsername();
                        $fMedico = USingleton::getInstance('FMedico');
                        return $fMedico->confermaUser($this->getUsername());
//                        break;
                    
                    case 'clinica':
                        $username = $this->getUsername();
                        $fClinica = USingleton::getInstance('FClinica');
                        return $fClinica->confermaUser($this->getUsername());
//                        break;
                    
                    default: 
                        echo 'errore durante la conferma';
                        break;
                }
                
    }
    
    /**
     * Metodo che permette di ottenere il tipo di utente
     * 
     * @access private
     * @return string Il tipo di utente  
     */
    private function getUser()
    {
        if(isset($_REQUEST['utente']))
       {
            $parametro = $_REQUEST['utente'];
       }
       return $parametro;
    }
    
    /**
     * Metodo che permette di ottenere l'username dell'utente/medico/clinica
     * 
     * @access private
     * @return string l'username  
     */
    private function getUsername()
    {
        if(isset($_REQUEST['username']))
       {
            $parametro = $_REQUEST['username'];
       }
       return $parametro;
    }
}
