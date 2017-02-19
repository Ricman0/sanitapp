<?php

/**
 * La classe CAutenticazione si occupa di gestire il necessario per l'autenticazione degli user.
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
    public function tryAutenticaUser() {                                        //controllato
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
     * Metodo che consente di gestire le eccezioni della funzione autenticaUser().
     * 
     * @access private
     * @param string $errore Il messaggio di errore                             //controllato
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
     * Metodo che consente di ottenere la pagina per poter recupera la password.
     * 
     * @access public
     */
    public function recuperaPasswordPagina() {                                  //controllato
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $vAutenticazione->visualizzaTemplate('recuperoCredenziali');
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
     * Metodo che tenta di autenticare un user, in caso contrario lancia eccezione.
     * 
     * @access public
     * @throws DatiLogInException Se i dati di log in non validi o uno dei due campi risulta vuoto
     * @throws XUserException Quando lo user da istanziare non esiste
     * @throws XDBException Se la query per cercare un user non è eseguita con successo
     */
    public function autenticaUser() {                                           //controllato
        $sessione = USingleton::getInstance('USession');
        $uCookie = USingleton::getInstance('UCookie');
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $this->controllaUserAutenticatoEImpostaHeader();
        $username = $vAutenticazione->recuperaValore('usernameLogIn');
        $password = $vAutenticazione->recuperaValore('passwordLogIn');
        if (!empty($username) && !empty($password)) { // se non è stato ancora autenticato ma ha inserito di dati di log in
            $datiLogIn = array('username' => $username, 'password' => $password);
            $validazione = USingleton::getInstance('UValidazione');
            if ($validazione->validaDati($datiLogIn) === TRUE) {
                $eUser = new EUser($username, $password);
                $uCookie->eliminaCookie('Tentativi');
                if ($eUser->getConfermatoUser() == TRUE && $eUser->getBloccatoUser() == FALSE) {// user confermato e non bloccato
                    $eUser->attivaSessioneUser($username, $eUser->getTipoUserUser());
                    $vAutenticazione->setTastiLaterali($eUser->getTipoUserUser());
                    if($eUser->getTipoUserUser()==='clinica')
                    {
                        $eClinica = new EClinica($username);
                        if($eClinica->getValidatoClinica()==TRUE)
                        {
                            $vAutenticazione->impostaHeaderEPaginaPersonale($sessione->leggiVariabileSessione('usernameLogIn'));
                        }
                        else
                        {
                            // mostra pagina validazione;
                            $eClinica->terminaSessioneUser();
                            $vAutenticazione->infoValidazione();
                        }
                    }
                    elseif($eUser->getTipoUserUser()==='medico')
                    {
                        $eMedico = new EMedico(NULL, $username);
                        if($eMedico->getValidatoMedico()==TRUE)
                        {
                            $vAutenticazione->impostaHeaderEPaginaPersonale($sessione->leggiVariabileSessione('usernameLogIn'));
                        }
                        else
                        {
                            // mostra pagina validazione;
                            $eMedico->terminaSessioneUser();
                            $vAutenticazione->infoValidazione();
                        }
                    }
                    else{
                        $vAutenticazione->impostaHeaderEPaginaPersonale($sessione->leggiVariabileSessione('usernameLogIn'));
                    }
                    
                } //user non confermato o bloccato ma esistente nel DB
                elseif($eUser->getBloccatoUser() == TRUE) {  //user bloccato
                    
                    $messaggio[0] = 'User Bloccato.';
                    $messaggio[1] = "Per risolvere il problema, contatti l'amministratore.";
                    $vAutenticazione->impostaHeaderMain($messaggio);
                }
                else { // user non confermato e non bloccato
                    // ritorna form per effettuare conferma
                    $vAutenticazione->impostaPaginaConferma($username);
                }
            } else { // dati non validi
                throw new DatiLogInException('Dati inseriti non validi.');
            }
        } else {//campi/o vuoti/o 
            throw new DatiLogInException('Almeno un campo del log in vuoto.');
        }
    }

    /**
     * Metodo che consente il log out dell'utente e effettua una refresh della pagina.
     * 
     * @access public
     */
    public function logOut() {
        $sessione = USingleton::getInstance('USession');
        $sessione->terminaSessione();
        $this->controllaUserAutenticatoEImpostaHeader();
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $vAutenticazione->restituisciHomePage();
    }

    /**
     * Metodo che consente di generare una nuova password e invia una mail contenente la nuova password.
     * 
     * @access public
     */
    public function nuovaPassword() {                                           //controllato
        $vAutenticazione = USingleton::getInstance('VAutenticazione');
        $uMail = USingleton::getInstance('UMail');
        $dati['email'] = $vAutenticazione->recuperaValore('email');
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($dati)) {
            try {
                $eUser = new EUser(NULL, NULL, $dati['email']);
                if ($eUser->getEmailUser() !== NULL) { //l'utente esiste
                    $password = $eUser->generatePassword();
                    $eUser->modificaPassword($password);
                    $dati['username'] = $eUser->getUsernameUser();
                    $dati['password'] = $password;
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
