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
    
    
    
    
    public function autenticaUser()
    {
        $sessione = USingleton::getInstance('USession');
        $uTentativi = USingleton::getInstance('UCookie');
        $uUsername =  USingleton::getInstance('UCookie');
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $username = $vAutenticazione->getDatoLogIn('uname');
        $password = $vAutenticazione->getDatoLogIn('psw');
        if($username!==FALSE && $password!==FALSE)
        {
            
//            $datiLogIn = array();
//            $datiLogIn['username'] = $username;
//            $datiLogIn['password'] = $password;
            $datiLogIn = array('username' => $username, 'password' => $password);
            $validazione = USingleton::getInstance('UValidazione');
            if($validazione->validaDatiLogIn($datiLogIn) === TRUE)
            {
                //username e password validi
                //cerco nel db se esistono
                $fDatabase = USingleton::getInstance('FDatabase');
                $username = $fDatabase->trimEscapeStringa($username);
                $password = $fDatabase->trimEscapeStringa($password);
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
                
//                foreach($risultato  as $row)
//                    {
//                      foreach($row  as $chiave => $valore)
//                      {
//                          
//                          echo $chiave . " " . $valore . " ";
//                      }
//                    }
                if ($risultato === FALSE)
                {
                    echo "errore nell'effettuare il log in";
                    // incremento il tentativo nel cookie?
                    $uTentativi->incrementaCookie();  
                    // 3 tentativi
                    if($uTentativi < 4)
                    {
                        // pagina di log in
                    }
                    else
                    {
                        // pagina recupero credenziali 
                    }
                }
                else
                {
                    
                    $sessione->impostaVariabileSessione('usernameLogIn', $username);
                    $uUsername->impostaCookie('username', $username, time() + 15 * 60);
                    $sessione->impostaVariabileSessione('LoggedIn', TRUE);
                    /*    usato per capire come è strutturato il risutlato
                    foreach($risultato  as $row)
                    {
                      foreach($row  as $chiave => $valore)
                      {
                          echo $chiave . " " . $valore . " ";
                      }
                    }     */
                    if(isset($risultato[0]['Utente']))
                    {
                        $tipo = $risultato[0]['Utente']; 
                    }
                    if(isset($risultato[0]['Medico']))
                    {
                        $tipo = $risultato[0]['Medico']; 
                    }
                    if(isset($risultato[0]['Clinica']))
                    {
                        $tipo = $risultato[0]['Clinica']; 
                    }
                    echo $tipo;
                    $sessione->impostaVariabileSessione('tipoUser', $tipo);
                    echo " Benvenuto " . $username;
                    // mostrare la pagina personale
                    
//                    $vAutenticazione->visualizzaTemplate("areaPersonale");  
                }
            }            
        }
        else
        {
            // il cookie tentativi aumenta di uno e ritorna la form per effettuare il log in
            echo "errore ";
            $uTentativi->incrementaCookie();
            // questo ramo non dovrebbe esserci perchè lato client richiedo necessariamente i due input
        }
        echo " QWERTY ";
        if($sessione->leggiVariabileSessione('LoggedIn')===TRUE && $sessione->leggiVariabileSessione('usernameLogIn')===$username)
        {
            $uTentativi->eliminaCookie('Tentativi');
            $vAutenticazione->impostaPaginaPersonale($sessione->leggiVariabileSessione('tipoUser'));
        }
        else 
        {
            if($uTentativi<4)
            {
                //pagina Log in
                $vAutenticazione->impostaPaginaLogIn();
            }
            else
            {
                // recupera Credenziali
                $vAutenticazione->impostaPaginaRecuperoCredenziali();
            }
        }
    }
}
