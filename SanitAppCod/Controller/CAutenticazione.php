<?php

/**
 * Description of CAutenticazione
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CAutenticazione {

    /**
     * Metodo che tenta di autenticare un user, in caso contrario cattura l'eccezione e la gestisce.
     * 
     * @access public
     */
    public function tryAutenticaUser() {
        try {
            $this->autenticaUser();
        } catch (XUserException $e) {
            $errore = $e->getMessage();
            $this->gestisciEccezioneAutenticaUser($errore);
        } catch (XDatiLogInException $e) {
            $errore = $e->getMessage(); // vorrei usare l'errore nel template per far visualizzare il messaggio di errore all'user
            $this->gestisciEccezioneAutenticaUser($errore);
        }
         catch (XDBExceptionException $e) {
            $errore = "C'è stato un errore durante l'autenticazione."; 
            $this->gestisciEccezioneAutenticaUser($errore);
        }
    }

    /**
     * Metodo che consente di gestire le eccezioni della funzione autenticaUser()
     * 
     * @access private
     * @param string $errore Il messaggio di errore
     */
    private function gestisciEccezioneAutenticaUser($errore) {
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $uCookie = USingleton::getInstance('UCookie');
        $uCookie->incrementaCookie('Tentativi');  //incremento il cookie Tentativi                    
        if ($uCookie->checkValiditaTentativi()) { // massimo 3 tentativi
            // pagina di log 
            $vAutenticazione->impostaLogIn($errore);
        } else {
            // pagina recupero credenziali 
            $uCookie->eliminaCookie('Tentativi');
            $vAutenticazione->impostaPaginaRecuperoCredenziali();
        }
    }


    /**
     * Metodo che permette di controllare se un user è autenticato e imposta l'header.
     * 
     * @access public
     */
    public function controllaUserAutenticatoEImpostaHeader() {                  //controllato
        $username = NULL;
        $sessione = USingleton::getInstance('USession');
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        if ($sessione->checkVariabileSessione("loggedIn") === TRUE) { // se è già autenticato
            //user autenticato            
            $username = $sessione->leggiVariabileSessione('usernameLogIn');
            $vAutenticazione->impostaHeader($username);
        } else {
            $vAutenticazione->impostaHeader();
        }
    }

    /**
     * Metodo che tenta di autenticare un user, in caso contrario lancia eccezione non gestita.
     * 
     * @access public
     * @throws DatiLogInException Se i dati di log in non validi o uno dei due campi risulta vuoto
     * @throws XUserException Quando lo user da istanziare non esiste
     * @throws XDBException Se la query per cercare un user non è eseguita con successo
     */
    public function autenticaUser() {
        $sessione = USingleton::getInstance('USession');
        $uCookie = USingleton::getInstance('UCookie');
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $this->controllaUserAutenticatoEImpostaHeader();
        if (!empty($username = $vAutenticazione->recuperaValore('usernameLogIn')) && !empty($password = $vAutenticazione->recuperaValore('passwordLogIn'))) { // se non è stato ancora autenticato ma ha inserito di dati di log in
            $datiLogIn = array('username' => $username, 'password' => $password);
            $validazione = USingleton::getInstance('UValidazione');
            if ($validazione->validaDati($datiLogIn) === TRUE) {
                $eUser = new EUser($username, $password);
//                if($eUser->getUsernameUser()!==NULL && $eUser->getPasswordUser()!==NULL)// caso in cui esiste l'user con quella password e quella username
//                {
                
                $uCookie->eliminaCookie('Tentativi');
                if ($eUser->getConfermatoUser() == TRUE && $eUser->getBloccatoUser() == FALSE) {// user confermato
                    $eUser->attivaSessioneUser($username, $eUser->getTipoUserUser());
                    $vAutenticazione->setTastiLaterali($eUser->getTipoUserUser());
                    $vAutenticazione->impostaHeaderEPaginaPersonale($sessione->leggiVariabileSessione('usernameLogIn'));
                } //user non confermato o bloccato ma esistente nel DB
                elseif($eUser->getBloccatoUser() == TRUE) {  //user bloccato
                    
                    $messaggio[0] = 'User Bloccato.';
                    $messaggio[1] = "Per risolver il problema, contatti l'amministretore.";
                    $vAutenticazione->impostaHeaderMain($messaggio);
                }
                else { // user non confermato e non bloccato
                    // ritorna form per effettuare conferma
                    
                    $vAutenticazione->impostaPaginaConferma($username);
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
            } else { // dati non validi
                throw new DatiLogInException('Dati inseriti non validi');
//                $vAutenticazione->impostaPaginaLogIn();
            }
        } else {//campi/o vuoti/o 
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
    public function logOut() {
        $sessione = USingleton::getInstance('USession');
        $sessione->terminaSessione();
        $this->controllaUserAutenticatoEImpostaHeader();
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
//        $vAutenticazione->logOut();
        $vAutenticazione->restituisciHomePage();
    }

    /**
     * Metodo che consente di generare una nuova password e invia una mail contenente la nuova password.
     * 
     * @access public
     */
    public function nuovaPassword() {
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $uMail = USingleton::getInstance('UMail');
        $dati['email'] = $vAutenticazione->recuperaValore('email');
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($dati)) {
            try {
                $eUser = new EUser(NULL, NULL, $dati['email']);
                if ($eUser->getEmailUser() !== NULL) { //l'utente esiste
                    $eUser->modificaPassword();
                    $dati['username'] = $eUser->getUsernameUser();
                    $dati['password'] = $eUser->getPasswordUser();
                    if ($uMail->inviaMailRecuperaPassword($dati)) {
                        $vAutenticazione->visualizzaFeedback('Ti è stata inviata la nuova password sulla mail.', TRUE);
                    } else {
                        $vAutenticazione->visualizzaFeedback("Problema con l'invio della mail, contatta l'amministratore", TRUE);
                    }
                } else {
                    $vAutenticazione->visualizzaFeedback("Alla email fornita non corrisponde nessun utente.", TRUE);
                }
            } catch (XUserException $ex) {//l'utente non esiste                        
                $vAutenticazione->visualizzaFeedback("Alla email fornita non corrisponde nessun utente.", TRUE);
            }
        } else {
            $vAutenticazione->visualizzaFeedback("Attenzione dati non validi.", TRUE);
        }
    }

}
