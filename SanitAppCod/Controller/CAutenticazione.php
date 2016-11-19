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
     * Metodo che tenta di autenticare un user, in caso contrario cattura l'eccezione e la gestisce
     * 
     * @access public
     */
    public function tryAutenticaUser() 
    {
        try
        {
            $this->autenticaUser();
        }
        catch (UserException $e)
        {
            gestisciEccezioneAutenticaUser();                   
        }
        catch (DatiLogInException $e)
        {
            $errore = $e->getMessage(); // vorrei usare l'errore nel template per far visualizzare il messaggio di errore all'user
            $this->gestisciEccezioneAutenticaUser($errore);              
        }
        
    }
    
    /**
     * Metodo che consente di gestire le eccezioni della funzione autenticaUser()
     * 
     * @access private
     * @param string $errore Il messaggio di errore
     */
    private function gestisciEccezioneAutenticaUser($errore) 
    {
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $uCookie = USingleton::getInstance('UCookie');
        $uCookie->incrementaCookie('Tentativi');  //incremento il cookie Tentativi                    
        if($uCookie->checkValiditaTentativi()) // massimo 3 tentativi
        {
            // pagina di log 
            $vAutenticazione->impostaPaginaLogIn();
        }
        else
        {
            // pagina recupero credenziali 
            $uCookie->eliminaCookie('Tentativi');
            $vAutenticazione->impostaPaginaRecuperoCredenziali();
        }  
    }
    
    /**
     * Metodo che permette di controllare se è stato effettuato il login
     * 
     * @access public
     * @param USession $session la sessione 
     * @return boolean true se è stato effettuato il login,
     *                 false altrimenti
     */
//    public function logIn($session) 
//    {
//        $logIn = $session->checkVariabileSessione("loggedIn");       
//        return $logIn;
//    }
    
    /**
     * Metodo che permette di controllare se un user è autenticato eimposta l'header
     * 
     * @access public
     */
    public function controllaUserAutenticatoEImpostaHeader() 
    {
        $username = NULL;
        $sessione = USingleton::getInstance('USession');
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        if($sessione->checkVariabileSessione("loggedIn") === TRUE) // se è già autenticato
        {
            //user autenticato            
            $username = $sessione->leggiVariabileSessione('usernameLogIn');
            $vAutenticazione->impostaHeader($username);
        }
        else
        {
            $vAutenticazione->impostaHeader();            
        }
    }
            
            
            
            
            
//            $fDatabase = USingleton::getInstance('FDatabase');
//            $username = $fDatabase->trimEscapeStringa($_POST['usernameLogIn']);
//            $password = $fDatabase->trimEscapeStringa($_POST['passwordLogIn']);
//            // vorrei eseguire query multiple
//            $query =  "SELECT Username, Password, 'Utente', "
//                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
//                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
//                    . "FROM utente WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
//                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE)); "
//                    . "SELECT Username, Password, 'Medico', "
//                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
//                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
//                    . "FROM medico WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
//                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE)); "
//                    . "SELECT Username, Password, 'Clinica', "
//                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
//                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
//                    . "FROM clinica WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
//                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE));";
//            $risultato = $fDatabase->eseguiQueryMultiple($query);
//            if ($risultato === FALSE)
//            {
//                echo "errore nell'effettuare il log in";
//                // incremento il tentativo nel cookie?
//            }
//            else
//            {
//                $sessione->impostaVariabileSessione('usernameLogIn', $username);
//                $sessione->impostaVariabileSessione('loggedIn', TRUE);
//                $tipo = $risultato[2]; // ??? è giusto così?
//                $sessione->impostaVariabileSessione('tipoUser', $tipo);
//                echo "Benvenuto" + $username;
//                print_r($_SESSION);
//            }
//        }
//        else
//        {
//            // display the login form
//            
//            //imposto la variabile di sessione loggedIn a False
//            $sessione->impostaVariabileSessione('loggedIn', FALSE);
//            
////        }
//        return $sessione;
    
    
    
    
    
    public function autenticaUser()
    {
        $sessione = USingleton::getInstance('USession');
        $uCookie = USingleton::getInstance('UCookie');
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $this->controllaUserAutenticatoEImpostaHeader();
        if(!empty($username=$vAutenticazione->recuperaValore('usernameLogIn')) && !empty($password=$vAutenticazione->recuperaValore('passwordLogIn'))) // se non è stato ancora autenticato ma ha inserito di dati di log in
        {            
            $datiLogIn = array('username' => $username, 'password' => $password);
            $validazione = USingleton::getInstance('UValidazione');
            if($validazione->validaDati($datiLogIn) === TRUE)
            {            
                $eUser = new EUser($username, $password);
//                if($eUser->getUsername()!==NULL && $eUser->getPassword()!==NULL)// caso in cui esiste l'user con quella password e quella username
//                {
                    $uCookie->eliminaCookie('Tentativi');
                    if($eUser->getConfermato() == TRUE)// user confermato
                    {
                        $eUser->attivaSessioneUser($username, $eUser->getTipoUser() );
                        $vAutenticazione->setTastiLaterali($eUser->getTipoUser() );
                        $vAutenticazione->impostaHeaderEPaginaPersonale($sessione->leggiVariabileSessione('usernameLogIn'));
                     
                    }
                    else //user non confermato ma esistente nel DB
                    {
                        // ritorna form per effettuare conferma
                        $vAutenticazione->impostaPaginaConferma();
                    }
//                }
//                else 
//                {
//                    $uCookie->incrementaCookie('Tentativi');  //incremento il cookie Tentativi
//                    
//                    if($uCookie->checkValiditaTentativi()) // massimo 3 tentativi
//                    {
//                        // pagina di log 
//                        
//                        $vAutenticazione->impostaPaginaLogIn();
//                    }
//                    else
//                    {
//                        // pagina recupero credenziali 
//                        $uCookie->eliminaCookie('Tentativi');
//                        $vAutenticazione->impostaPaginaRecuperoCredenziali();
//                    }
//                }
            }
            else // dati non validi
            {
                throw new DatiLogInException('Dati inseriti non validi');
//                $vAutenticazione->impostaPaginaLogIn();
            }
        }
        else//campi/o vuoti/o 
        {
            throw new DatiLogInException('Almeno un campo del log in vuoto');
//            $vAutenticazione->impostaPaginaLogIn();
        }
    }
        
    
        
        
//        $tastiLaterali = Array();
//        if($username!==FALSE && $password!==FALSE)
//        {
//            
////            $datiLogIn = array();
////            $datiLogIn['username'] = $username;
////            $datiLogIn['password'] = $password;
//            $datiLogIn = array('username' => $username, 'password' => $password);
//            $validazione = USingleton::getInstance('UValidazione');
//            if($validazione->validaDati($datiLogIn) === TRUE)
//            {
//                //username e password validi
//                //cerco nel db se esistono
//                $fDatabase = USingleton::getInstance('FDatabase');
//                $username = $fDatabase->trimEscapeStringa($username);
//                $password = $fDatabase->trimEscapeStringa($password);
//                $query =  "SELECT Username, Password, 'Utente', "
//                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
//                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
//                    . "FROM utente WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
//                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE)); "
//                    . "SELECT Username, Password, 'Medico', "
//                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
//                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
//                    . "FROM medico WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
//                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE)); "
//                    . "SELECT Username, Password, 'Clinica',NomeClinica, "
//                    . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE), "
//                    . "MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) "
//                    . "FROM clinica WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
//                    . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE));";
//                $risultato = $fDatabase->eseguiQueryMultiple($query);
//                
////                foreach($risultato  as $row)
////                    {
////                      foreach($row  as $chiave => $valore)
////                      {
////                          
////                          echo $chiave . " " . $valore . " ";
////                      }
////                    }
//                if ($risultato === FALSE)
//                {
//                    echo "errore nell'effettuare il log in";
//                    // incremento il tentativo nel cookie?
//                    $uTentativi->incrementaCookie();  
//                    // 3 tentativi
//                    if($uTentativi < 4)
//                    {
//                        // pagina di log in
//                    }
//                    else
//                    {
//                        // pagina recupero credenziali 
//                    }
//                }
//                else
//                {
//                    
//                    $sessione->impostaVariabileSessione('usernameLogIn', $username);
//                    $uUsername->impostaCookie('username', $username, time() + 15 * 60);
//                    $sessione->impostaVariabileSessione('loggedIn', "TRUE");
//                    /*    usato per capire come è strutturato il risutlato
//                    foreach($risultato  as $row)
//                    {
//                      foreach($row  as $chiave => $valore)
//                      {
//                          echo $chiave . " " . $valore . " ";
//                      }
//                    }     */
//                    if(isset($risultato[0]['Utente']))
//                    {
//                        $tipo = $risultato[0]['Utente']; 
//                        $tastiLaterali['prenotazioniAreaPersonaleUtente'] = "Prenotazioni";
//                        $tastiLaterali['refertiAreaPersonaleUtente'] = "Referti";
//                        $tastiLaterali['impostazioniAreaPersonaleUtente'] = "Impostazioni";
//                    }
//                    if(isset($risultato[0]['Medico']))
//                    {
//                        $tipo = $risultato[0]['Medico']; 
//                        $tastiLaterali['pazientiAreaPersonaleMedico'] = "Pazienti";
//                        $tastiLaterali['prenotazioniAreaPersonaleMedico'] = "Prenotazioni";
//                        $tastiLaterali['refertiAreaPersonaleMedico'] = "Referti";
//                        $tastiLaterali['impostazioniAreaPersonaleMedico'] = "Impostazioni";
//                    }
//                    if(isset($risultato[0]['Clinica']))
//                    {
//                        $tipo = $risultato[0]['Clinica'];
//                        $nome = $risultato[0]['NomeClinica'];
//                        $sessione->impostaVariabileSessione('nomeClinica', $nome);
//                        $tastiLaterali['serviziAreaPersonaleClinica'] = "Servizi";
//                        $tastiLaterali['prenotazioniAreaPersonaleClinica'] = "Prenotazioni";
//                        $tastiLaterali['refertiAreaPersonaleClinica'] = "Referti";
//                        $tastiLaterali['clientiAreaPersonaleClinica'] = "Clienti";
//                        $tastiLaterali['impostazioniAreaPersonaleClinica'] = "Impostazioni";
//                    }
//                    echo $tipo;
//                    $sessione->impostaVariabileSessione('tipoUser', $tipo);
//                    print_r($_SESSION);
//                    echo " Benvenuto " . $username;
//                    // mostrare la pagina personale
//                    
////                    $vAutenticazione->visualizzaTemplate("areaPersonale");  
//                }
//            }            
//        }
//        else
//        {
//            // il cookie tentativi aumenta di uno e ritorna la form per effettuare il log in
//            echo "errore ";
//            $uTentativi->incrementaCookie();
//            // questo ramo non dovrebbe esserci perchè lato client richiedo necessariamente i due input
//        }
//        echo " QWERTY ";
//        if($sessione->leggiVariabileSessione('loggedIn')==="TRUE" && $sessione->leggiVariabileSessione('usernameLogIn')===$username)
//        {
//            $uTentativi->eliminaCookie('Tentativi');
////            $vAutenticazione->impostaPaginaPersonale($sessione->leggiVariabileSessione('tipoUser'), $tastiLaterali);
//            $vAutenticazione->impostaHeaderEPaginaPersonale($sessione->leggiVariabileSessione('usernameLogIn'), $tastiLaterali);
//            
//        }
//        else 
//        {
//            if($uTentativi<4)
//            {
//                //pagina Log in
//                $vAutenticazione->impostaPaginaLogIn();
//            }
//            else
//            {
//                // recupera Credenziali
//                $vAutenticazione->impostaPaginaRecuperoCredenziali();
//            }
//        }
//    }
    
    /**
     * Metodo che consente il log out dell'utente e effettua una refresh della pagina
     * 
     * @access public
     */
    public function logOut() 
    {
        $sessione = USingleton::getInstance('USession');
        $sessione->terminaSessione();
        $this->controllaUserAutenticatoEImpostaHeader() ;
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
//        $vAutenticazione->logOut();
        $vAutenticazione->restituisciHomePage();
    }
}
