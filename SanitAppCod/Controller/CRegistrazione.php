<?php

/**
 * Description of CRegistrazione
 * 
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRegistrazione {

    /**
     * Metodo che permette di impostare la pagina di registrazione
     * 
     * @access public
     */
    public function impostaPaginaRegistrazione() {
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
     * Metodo che permette l'inserimento di un utente, medico o clinica nel db
     * 
     * @access public
     */
    public function inserisciRegistrazione() {
        
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        switch ($vRegistrazione->getTask()) {
            case 'clinica': {
                    $codiceODatiValidi = $this->recuperaDatiECreaClinica();
                    if (is_string($codiceODatiValidi) === TRUE) {//se contiene il codice di conferma
                        $this->inviaMailRegistrazioneClinica($codiceODatiValidi);
                    } else {
                        // dati corretti ma errore nel database
                        return $vRegistrazione->restituisciFormClinica($codiceODatiValidi);
                    }
                }
                break;

            case 'medico': {
                    $codiceODatiValidi = $this->recuperaDatiECreaMedico();
                        if (is_string($codiceODatiValidi) === TRUE) {//se contiene il codice di conferma
                            $this->inviaMailRegistrazioneMedico($codiceODatiValidi);
                        } else {
                            // dati corretti ma errore nel database
                            return $vRegistrazione->restituisciFormMedico($codiceODatiValidi);
                        }
                    }

                    break;
                
            case 'utente': {
                    try {
                        $codiceODatiValidi = $this->recuperaDatiECreaUtente();
                        if (is_string($codiceODatiValidi) === TRUE) {//se contiene il codice di conferma
                            $this->inviaMailRegistrazioneUtente($codiceODatiValidi);
                        } else {
                            // dati corretti ma errore nel database
                            return $vRegistrazione->restituisciFormUtente($codiceODatiValidi);
                        }
                    } catch (XDBException $exc) {
                        $vRegistrazione->visualizzaFeedback($exc->getMessage(), TRUE);
                    }
                }
                break;

            default:
                break;
        }
    }

    /**
     * Metodo che permette di recuperare i dati inserirti nella form di registrazione e utilizza
     * tali dati per creare e inserire una nuova clinica nel database.
     * 
     * @access private
     * @return mixed Se i dati sono validi il codice di conferma la clinica è stata inserita nel DB, FALSE altrimenti. Se i dati non sono validi, i dati validi
     */
    private function recuperaDatiECreaClinica() {
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
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo medico nel database
     * 
     * @access private
     * @return mixed Se i dati sono validi il codice di conferma  il medico è stato inserito nel DB. Se i dati non sono validi, i dati validi
     */
    private function recuperaDatiECreaMedico() {
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
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo utente nel database
     * 
     * @access private
     * @return mixed Se i dati sono validi il codice di conferma l'utente è stato inserito nel DB. Se i dati non sono validi, i dati validi
     */
    private function recuperaDatiECreaUtente() {
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
     * Invia mail riscontro dell’avvenuta registrazione al medico contenente 
     * informazioni riepilogative e con link di conferma
     * 
     * @param string $codice codice conferma registrazione
     */
    private function inviaMailRegistrazioneMedico($codice) {
        
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
     * invia mail riscontro dell’avvenuta registrazione all'utente contenente 
     * informazioni riepilogative e con link di conferma
     * 
     * @param string $codice codice conferma registrazione
     */
    private function inviaMailRegistrazioneUtente($codice) {

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
     * Invia mail riscontro dell’avvenuta registrazione alla clinica contenente 
     * informazioni riepilogative e con link di conferma
     * 
     * @param string $codice codice conferma registrazione
     */
    private function inviaMailRegistrazioneClinica($codice) {
        
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
     * Metodo che consente di confermare un user gestendo anche eventuali eccezioni/errori
     * 
     * @access public
     * @param string $username L'username a cui corrisponde lo user da confermare
     * @param type $idConferma Il codice di conferma
     */
    public function tryConfermaUser($username, $idConferma) {
        $vRegistrazione = USingleton::getInstance('VRegistrazione');
        try {
            $eUser = new EUser($username);
            if ($eUser->confermaUser($idConferma) === TRUE) {
                $messaggio = 'User Confermato';
                $vRegistrazione->visualizzaFeedback($messaggio, TRUE);
            } else {
                $messaggio = "C'è stato un errore, non è possibile confermare questo account.";
                $vRegistrazione->visualizzaFeedback($messaggio);
            }
        } catch (XUserException $ex) {
            $vRegistrazione->visualizzaFeedback($ex->getMessage());
        } catch (XDBException $ex) {
            $vRegistrazione->visualizzaFeedback($ex->getMessage());
        }
    }

}
