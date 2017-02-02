<?php

/**
 * La classe CRegistrazione si occupa di gestire il controller 'registrazione'.
 * 
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRegistrazione {

    /**
     * Metodo che permette di impostare la pagina di registrazione.
     * 
     * @access public
     */
    public function impostaPaginaRegistrazione() {                              //controllato
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        switch ($vRegistrazione->getTask()) { // imposta la pagina in base al task contenuto nell'url
            case 'conferma':
                $username = $vRegistrazione->recuperaValore('username');
                $idConferma = $vRegistrazione->recuperaValore('id');
                if ($idConferma !== FALSE && $username !== FALSE) { //GET registrazione/conferma/username/idConferma
                    $this->tryConfermaUser($username, $idConferma);
                } else {
                    $messaggio = "Codice conferma o username non trovato. Non è possibile confermare questo account.";
                    $vRegistrazione->visualizzaFeedback($messaggio);
                }
                break;

            case 'clinica':
                $vRegistrazione->restituisciFormClinica();
                break;

            case 'medico':
                $vRegistrazione->restituisciFormMedico();
                break;

            default:    // l'ultimo caso è quello di utente
                $vRegistrazione->restituisciFormUtente();
                break;
        }
    }

    /**
     * Metodo che consente di gestire le richieste HTTP POST del controller 'registrazione'.
     * 
     * @access public
     */
    public function gestisciRegistrazionePOST(){                                //controllato
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        if($vRegistrazione->getTask()==='conferma')
        { //POST registrazione/conferma
            $username = $vRegistrazione->recuperaValore('username');
            $idConferma = $vRegistrazione->recuperaValore('id');
            if ($idConferma !== FALSE && $username !== FALSE) { 
                $this->tryConfermaUser($username, $idConferma);
            }
            else {
                $messaggio = "Codice conferma o username non trovato. Non è possibile confermare questo account.";
                $vRegistrazione->visualizzaFeedback($messaggio);
            }
        }
        else
        {
            $this->inserisciRegistrazione();
        }
    }
    
    /**
     * Metodo che permette l'inserimento di un utente, medico o clinica nel DB.
     * 
     * @access public
     */
    public function inserisciRegistrazione() {                                  //controllato
        
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        switch ($vRegistrazione->getTask()) {
            case 'clinica': {
                    try{
                        $codiceODatiValidi = $this->recuperaDatiECreaClinica();
                        if (is_string($codiceODatiValidi) === TRUE) {//se contiene il codice di conferma
                            $this->inviaMailRegistrazioneClixnica($codiceODatiValidi);
                        } else {
                            //  alcuni dati corretti 
                            $vRegistrazione->restituisciFormClinica($codiceODatiValidi);
                        }
                    } catch (XDBException $exc) {
                        $vRegistrazione->visualizzaFeedback($exc->getMessage(), TRUE);
                    }
                    catch (XClinicaException $exc) {
                        $vRegistrazione->visualizzaFeedback("C'è stato un errore. Non è stato possibile registrare la clinica.", TRUE);
                    }
                }
                break;

            case 'medico': {
                try{
                    $codiceODatiValidi = $this->recuperaDatiECreaMedico();
                    if (is_string($codiceODatiValidi) === TRUE) {//se contiene il codice di conferma
                        $this->inviaMailRegistrazioneMedico($codiceODatiValidi);
                    } else {
                        // alcuni dati corretti
                        $vRegistrazione->restituisciFormMedico($codiceODatiValidi);
                    }
                } 
                catch (XDBException $exc) {
                        $vRegistrazione->visualizzaFeedback($exc->getMessage(), TRUE);
                    }
                catch (XMedicoException $exc) {
                        $vRegistrazione->visualizzaFeedback("C'è stato un errore. Non è stato possibile registrare il medico.", TRUE);
                    }
                }
                break;
                
            case 'utente': {                                                    //controllato
                    try {
                        $codiceODatiValidi = $this->recuperaDatiECreaUtente();
                        if (is_string($codiceODatiValidi) === TRUE) {//se contiene il codice di conferma
                            $this->inviaMailRegistrazioneUtente($codiceODatiValidi);
                        } else {
                            // alcuni dati sono corretti
                            $vRegistrazione->restituisciFormUtente($codiceODatiValidi);
                        }
                    } catch (XDBException $exc) {
                        $vRegistrazione->visualizzaFeedback($exc->getMessage(), TRUE);
                    }
                    catch (XMedicoException $exc) {
                        $vRegistrazione->visualizzaFeedback("C'è stato un errore. Non è stato possibile registrare l'utente.");
                    }
                }
                break;
              
                
            default:
                break;
        }
    }

    /**
     * Metodo che permette di recuperare i dati inseriti dalla clinica dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo medico nel database.
     * 
     * @access private
     * @return string|array Se i dati sono validi ritorna il codice di conferma poichè la clinica è stato inserita nel DB. Se i dati non sono validi, array contenente i dati validi.
     * @throws XDBException Errore durante l'esecuzione della query
     * @throws XMedicoException Se il medico è inesistente
     */
    private function recuperaDatiECreaClinica() {                               //controllato
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        //recupero i dati 
        $datiClinica = $vRegistrazione->recuperaDatiClinica();
        //ho recuperato tutti i dati inseriti nella form di registrazione della clinica
        //ora è necessario che vengano validati prima della creazione di una nuova clinica
        $uValidazione = USingleton::getInstance('UValidazione');
        $uValidazione->validaDati($datiClinica);
        // se i dati sono validi
        if ($uValidazione->getValidati() === TRUE) {
            // crea la clinica
            $eClinica = new EClinica($datiClinica['username'], $datiClinica['partitaIVA'], ucwords($datiClinica['nomeClinica']), $datiClinica['password'], $datiClinica['email'], ucwords($datiClinica['titolare']), ucwords($datiClinica['via']), $datiClinica['numeroCivico'], $datiClinica['cap'], ucwords($datiClinica['localitàClinica']), $datiClinica['provinciaClinica'], $datiClinica['PEC'], $datiClinica['telefono'], $datiClinica['capitaleSociale']);
            //eClinica richiama il metodo per creare FClinica poi FClinica aggiunge l'utente nel DB
            return $eClinica->inserisciClinicaDB(); // "ritorno" il codice di conferma
        } else {
            // non tutti i dati sono validi per cui restituisco la form per inserire la clinica con i dati validi inseriti
            return $uValidazione->getDatiValidi();
        }
    }

    /**
     * Metodo che permette di recuperare i dati inseriti dal medico dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo medico nel database.
     * 
     * @access private
     * @return string|array Se i dati sono validi ritorna il codice di conferma poichè il medico è stato inserito nel DB. Se i dati non sono validi, array contenente i dati validi.
     * @throws XDBException Errore durante l'esecuzione della query
     * @throws XMedicoException Se il medico è inesistente
     */
    private function recuperaDatiECreaMedico() {                                //controllato
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        //recupero i dati 
        $datiMedico = $vRegistrazione->recuperaDatiMedico();
        //ho recuperato tutti i dati inseriti nella form di registrazione del medico
        //ora è necessario che vengano validati prima della creazione di un nuovo medico
        $uValidazione = USingleton::getInstance('UValidazione');
        $uValidazione->validaDati($datiMedico);
        // se i dati sono validi
        if ($uValidazione->getValidati() === TRUE) {
            // crea utente 
            $eMedico = new EMedico($datiMedico['codiceFiscale'], $datiMedico['username'], ucwords($datiMedico['nome']), ucwords($datiMedico['cognome']), ucwords($datiMedico['via']), $datiMedico['numeroCivico'], $datiMedico['CAP'], $datiMedico['email'], $datiMedico['password'], $datiMedico['PEC'], $datiMedico['provinciaAlbo'], $datiMedico['numeroIscrizione']);
            //eMedico richiama il metodo per creare FMedico poi FMedico aggiunge l'utente nel DB
            return $eMedico->inserisciMedicoDB();
        } else {

            return $uValidazione->getDatiValidi();
        }
    }

    /**
     * Metodo che permette di recuperare i dati inseriti dall'utente dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo utente nel database.
     * 
     * @access private
     * @return string|array Se i dati sono validi ritorna il codice di conferma poichè l'utente è stato inserito nel DB. Se i dati non sono validi, array contenente i dati validi.
     * @throws XDBException Errore durante l'esecuzione della query
     * @throws XMedicoException Se il medico è inesistente
     */
    private function recuperaDatiECreaUtente() {                                //controllato
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        //recupero i dati 
        $datiUtente = $vRegistrazione->recuperaDatiUtente();
        //ho recuperato tutti i dati inseriti nella form di registrazione dell'utente
        //ora è necessario che vengano validati prima della creazione di un nuovo utente
        $uValidazione = USingleton::getInstance('UValidazione');
        $uValidazione->validaDati($datiUtente);
        // se i dati sono validi
        if ($uValidazione->getValidati() === TRUE) {
            // crea utente 
            $eUtente = new EUtente($datiUtente['codiceFiscale'], $datiUtente['username'], $datiUtente['password'], $datiUtente['email'], ucwords($datiUtente['nome']), ucwords($datiUtente['cognome']), ucwords($datiUtente['indirizzo']), $datiUtente['numeroCivico'], $datiUtente['CAP']);
            $sessione = USingleton::getInstance('USession');
            $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
            if ($tipoUser === 'medico') {
                $username = $sessione->leggiVariabileSessione('usernameLogIn');
                $eMedico = new EMedico(NULL, $username);
                $eUtente->setMedicoCurante($eMedico->getCodFiscaleMedico());
            }
            //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
            return $eUtente->inserisciUtenteDB();
        } else {
            // i dati validi
            return $uValidazione->getDatiValidi();
        }
    }
    
    
    /**
     * Metodo che consente di inviare un'email riscontro dell’avvenuta registrazione al medico contenente 
     * informazioni riepilogative e link di conferma.
     * 
     * @access private
     * @param string $codice codice conferma registrazione
     */
    private function inviaMailRegistrazioneMedico($codice) {                    //controllato
        
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        $uValidazione = USingleton::getInstance('UValidazione');
        $mail = USingleton::getInstance('UMail');
        if ($mail->inviaMailRegistrazioneMedico($codice, $uValidazione->getDatiValidi()) === TRUE) {
            $messaggio[0] = "Un'email è stata inviata all'indirizzo email inserito nella form. ";
            $messaggio[1] = "Per confermare la registrazione clicca sul link contenuto nella mail.";
            $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
        } else {
            $messaggio[0] = "C'è stato un errore durante l'invio della mail riepilogativa. ";
            $messaggio[1] = "Per risolvere il problema, contatta un amministratore. ";
            $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
        }
    }

    /**
     * Metodo che consente di inviare un'email riscontro dell’avvenuta registrazione all'utente contenente 
     * informazioni riepilogative e link di conferma.
     * 
     * @access private
     * @param string $codice codice conferma registrazione
     */
    private function inviaMailRegistrazioneUtente($codice) {                    //controllato

        $mail = USingleton::getInstance('UMail');
        $uValidazione = USingleton::getInstance('UValidazione');
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        if ($mail->inviaMailRegistrazioneUtente($codice, $uValidazione->getDatiValidi()) === TRUE) {
            $messaggio[0] = "Un'email è stata inviata all'indirizzo email inserito nella form. ";
            $messaggio[1] = "Per confermare la registrazione clicca sul link contenuto nella mail.";
            $sessione = USingleton::getInstance('USession');
            if ($sessione->leggiVariabileSessione('tipoUser') === 'medico') {
                $vRegistrazione->visualizzaFeedback($messaggio);
            } else {
                $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
            }
        } else {
            $messaggio[0] = "C'è stato un errore durante l'invio della mail riepilogativa. ";
            $messaggio[1] = "Per risolvere il problema, contatta un l'amministratore. ";
            $sessione = USingleton::getInstance('USession');
            if ($sessione->leggiVariabileSessione('tipoUser') === 'medico') {
                $vRegistrazione->visualizzaFeedback($messaggio);
            } else {
                $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
            }
        }
    }
    
    /**
     * Metodo che consente di inviare un'email riscontro dell’avvenuta registrazione alla clinica contenente 
     * informazioni riepilogative e link di conferma.
     * 
     * @access private
     * @param string $codice codice conferma registrazione
     */
    private function inviaMailRegistrazioneClinica($codice) {                   //controllato
        
        $mail = USingleton::getInstance('UMail');
        $uValidazione = USingleton::getInstance('UValidazione');
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        if ($mail->inviaMailRegistrazioneClinica($codice, $uValidazione->getDatiValidi()) === TRUE) {
            $messaggio[0] = "Un'email è stata inviata all'indirizzo email inserito nella form. ";
            $messaggio[1] = "Per confermare la registrazione clicca sul link contenuto nella mail.";
            $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
        } else {
            $messaggio[0] = "C'è stato un errore durante l'invio della mail riepilogativa. ";
            $messaggio[1] = "Per risolvere il problema, contatta un amministratore. ";
            $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
        }
    }

    /**
     * Metodo che consente di confermare un user gestendo anche eventuali eccezioni/errori.
     * 
     * @access public
     * @param string $username L'username a cui corrisponde lo user da confermare
     * @param type $idConferma Il codice di conferma
     */
    public function tryConfermaUser($username, $idConferma) {                   //controllato
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        try {
            $eUser = new EUser($username);
            if ($eUser->confermaUser($idConferma) === TRUE) {
                $messaggio = 'User Confermato';
                $vRegistrazione->visualizzaFeedback($messaggio);
            } else {
                $messaggio = "C'è stato un errore, non è possibile confermare questo account.";
                $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
            }
        } catch (XUserException $ex) {
            $vRegistrazione->visualizzaFeedback($ex->getMessage(), TRUE);
        } catch (XDBException $ex) {
            $vRegistrazione->visualizzaFeedback($ex->getMessage(), TRUE);
        }
    }

}
