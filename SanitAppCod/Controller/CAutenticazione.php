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
//    private function datiInviati() 
//    {
//        
//        if(!empty($_POST['username']) && !empty($_POST['password']))
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//        
//    }
    
    
//    public function impostaPaginaAutenticazione()
//    {
//        $vAutenticazione =  USingleton::getInstance('VAutenticazione');
//        $task= $vAutenticazione->getTask();
//        switch ($task)
//        {
//            case 'logIn':
//            
//                break;
//            default: 
//                break;
//        }
//    }
    
    /**
     * Metodo che permette l'autenticazione di un utente qualsiasi
     * 
     * @access public
     * @param USession $sessione La sessione relativa ad utente da controllare e modificare
     * @return USession La sessione eventualmente modificata se è stato autenticato un utente
     */
    public function autenticazioneUser($sessione) 
    {
//        if($this->logIn($sessione) === TRUE)
        if($sessione->checkVariabileSessione("loggedIn") === TRUE)
        {
            //user autenticato
            // questo if può essere eliminato se faccio ritornare $sessione
        }
        elseif (!empty($_POST['usernameLogIn']) && !empty($_POST['passwordLogIn'])) 
        {
            $fDatabase = USingleton::getInstance('FDatabase');
            $username = $fDatabase->trimEscapeStringa($_POST['usernameLogIn']);
            $password = $fDatabase->trimEscapeStringa($_POST['passwordLogIn']);
            // vorrei eseguire query multiple
            $query =  "SELECT Username, Password, 'Utente', "
                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
                    . "FROM utente WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE)); "
                    . "SELECT Username, Password, 'Medico', "
                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
                    . "FROM medico WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE)); "
                    . "SELECT Username, Password, 'Clinica', "
                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
                    . "FROM clinica WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE));";
            $risultato = $fDatabase->eseguiQueryMultiple($query);
            if ($risultato === FALSE)
            {
                echo "errore nell'effettuare il log in";
                // incremento il tentativo nel cookie?
            }
            else
            {
                $sessione->impostaVariabileSessione('usernameLogIn', $username);
                $sessione->impostaVariabileSessione('LoggedIn', TRUE);
                $tipo = $risultato[2]; // ??? è giusto così?
                $sessione->impostaVariabileSessione('tipoUtente', $tipo);
                echo "Benvenuto" + $username;
            }
        }
        else
        {
            // display the login form
            
            //imposto la variabile di sessione LoggedIn a False
            $sessione->impostaVariabileSessione('LoggedIn', FALSE);
            
        }
        return $sessione;
    }
}
