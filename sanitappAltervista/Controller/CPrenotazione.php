<?php

/**
 * La classe CPrenotazione si occupa della gestione delle prenotazioni.
 *
 * 
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CPrenotazione {

    /**
     * Metodo che consente di gestire le richieste GET per il controller 'prenotazione'.
     * 
     * @access public
     */
    public function gestisciPrenotazione() {
        $orari = Array();
        $date;   // è usato??
        
        $sessione = USingleton::getInstance('USession');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        if ($task !== FALSE) 
        {
            switch ($task) 
            {
                case 'conferma':
                $idPrenotazione = $vPrenotazione->recuperaValore('id') ;
                if($idPrenotazione !== FALSE && $tipoUser==='utente')
                {
                    try {
                        $ePrenotazione = new EPrenotazione($idPrenotazione);
                        if($ePrenotazione->confermaPrenotazione()===TRUE)
                        {
                            $vJSON = USingleton::getInstance('VJSON');
                            $vJSON->inviaDatiJSON(TRUE);
                        }
                        else
                        {
                            $vJSON = USingleton::getInstance('VJSON');
                            $vJSON->inviaDatiJSON(FALSE);
                        }
                    } catch (XPrenotazioneException $ex) {
                            $vJSON = USingleton::getInstance('VJSON');
                            $vJSON->inviaDatiJSON(FALSE);
                    }
                    catch (XDBException $ex) {
                            $vJSON = USingleton::getInstance('VJSON');
                            $vJSON->inviaDatiJSON(FALSE);
                    }
                
                    
                    
                }
                break;
                
                case 'esame':// GET prenotazione/esame
                    $id = $vPrenotazione->recuperaValore('id'); 
                    if(isset($id))// GET prenotazione/esame/idEsame
                    {
                        try {
                            $eEsame = new EEsame($id);
                            $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                            $eClinica = new EClinica(NULL, $partitaIVAClinica);
                            $nomeEsame = ucwords($eEsame->getNomeEsameEsame());
                            $durataEsame = $eEsame->getDurataEsame();
                            $nomeClinica = ucwords($eClinica->getNomeClinicaClinica());
                            $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $id, $durataEsame, NULL, $tipoUser);
                        } catch (XEsameException $ex) {
                            $vPrenotazione->visualizzaFeedback("C'è stato un errore. Se l'errore persiste, contatti l'amministratore.");
                        }
                        catch (XClinicaException $ex) {
                            $vPrenotazione->visualizzaFeedback("C'è stato un errore. Se l'errore persiste, contatti l'amministratore.");
                        }
                        catch (XDBException $ex) {
                            $vPrenotazione->visualizzaFeedback("C'è stato un errore. Se l'errore persiste, contatti l'amministratore.");
                        }
                    }
                    break;
                
                case 'modifica': // GET prenotazione/modifica
                    $this->tryModificaPrenotazione();
                    break;
                
                case 'ricerca': //GET prenotazione/ricerca
                    $id = $vPrenotazione->recuperaValore('id'); 
                    $vJSON = USingleton::getInstance('VJSON');
                    if(isset($id))// GET prenotazione/ricerca/idPrenotazione
                    {
                        try{
                            $ePrenotazione = new EPrenotazione($id);
                            $daInviare = array();
                            $daInviare['Eseguito'] = $ePrenotazione->getEseguitaPrenotazione();
                            $vJSON->inviaDatiJSON($daInviare);
                        }catch (XPrenotazioneException $ex) {
                            // prenotazione mancante
                            $vJSON->inviaDatiJSON(FALSE);
                            
                        }
                        catch (XDBException $ex) {
                            // problemi nel db
                             $vJSON->inviaDatiJSON(FALSE);
                        }
                    }
                    else {//errore
                         $vJSON->inviaDatiJSON(FALSE);
                        }
                    
                    break;
                    
                default:
                    break;
            }
        } 
        else 
        {
            $this->recuperaEInviaOrariDisponibili();   
        }
    }

    
    /**
     * Metodo che consente di gestire le richieste GET per il controller 'prenotazioni'.
     * 
     * @access public
     */
    public function gestisciPrenotazioni()                                      
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazioni->getTask();
        switch ($task) {                
            case 'visualizza':  // GET prenotazioni/visualizza                  //controllato
            $idPrenotazione = $vPrenotazioni->recuperaValore('id');
            if ($idPrenotazione === FALSE)  // GET prenotazioni/visualizza
            {
                $this->tryVisualizzaPrenotazioni();
            }
            else
            { // get prenotazioni/visualizza/id
                $this->tryVisualizzaPrenotazione($idPrenotazione);                              
            }



                break;

//            case 'aggiungi':
//                $vPrenotazioni->restituisciPaginaAggiungiPrenotazione();
//                break;
            case 'aggiungi':
                switch ($tipoUser) 
                {
                    case 'clinica':
                        try {
                            $eClinica = new EClinica($username);
                            $nomeClinica = $eClinica->getNomeClinicaClinica();
                            // visualizzo una pagina per cercare il cliente o l'utente registrato del sistema per cui in seguito vorrò effettuare una prenotazione
                            $vPrenotazioni->impostaPaginaCercaUtente($nomeClinica, 'clinica');
                            
                        } catch (XClinicaException $ex) {
                            $vPrenotazioni->visualizzaFeedback("C'è stato un errore. Se l'errore persiste, contatti l'amministratore.");
                        }
                        catch (XDBException $ex) {
                            $vPrenotazioni->visualizzaFeedback("C'è stato un errore. Se l'errore persiste, contatti l'amministratore.");
                        }
                        
                        break;

                    case 'medico':
                        try {
                            $eMedico= new EMedico(NULL, $username);
                            $vPrenotazioni->impostaPaginaCercaUtente($eMedico->getCodFiscaleMedico(), 'medico');
                        } catch (XMedicoException $ex) {
                            $vPrenotazioni->visualizzaFeedback("C'è stato un errore. Se l'errore persiste, contatti l'amministratore.");
                        }
                        catch (XDBException $ex) {
                            $vPrenotazioni->visualizzaFeedback("C'è stato un errore. Se l'errore persiste, contatti l'amministratore.");
                        }
                        

                    default:
                        break;
                }
            default:
                break;
        }
    }

    /**
     * Metodo che consente di gestire le richieste POST per il controller 'prenotazione'.
     * 
     * @access public
     */
    public function gestisciPrenotazionePOST() {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazione->getTask();
        switch ($task) {
            case 'elimina':
                try
                {
                    $this->eliminaPrenotazione();
                }
                catch (XValoreInesistenteException $e)
                {
                    // 'id della prenotazione  non è presente in $_REQUEST  
                    $vPrenotazione->prenotazioneEliminata(FALSE);
                }
                catch (XPrenotazioneException $e)
                {
                       // non esiste la prenotazione con quell'id  
                    //oppure quella prenotazione è già stata eseguita
                    $vPrenotazione->prenotazioneEliminata(FALSE);
                }
                catch (XDBException $e)
                {
                       // Se la query per eliminare la prenotazione specificata non è stata eseguita con successo
                     $vPrenotazione->prenotazioneEliminata(FALSE);
                }  
                catch (XUserException $e)
                {
                       // Se l'utente non esiste o se la clinica non esiste   
                    $vPrenotazione->prenotazioneEliminata(TRUE, FALSE);
                }
                catch (XEsameException $e)
                {
                       //Se l'esame non esiste 
                    $vPrenotazione->prenotazioneEliminata(TRUE, FALSE);
                }             
                catch (XMailException $e)
                {
                       // Se l'email non è inviata   
                    $vPrenotazione->prenotazioneEliminata(TRUE, FALSE);
                }
                break;
            
            case 'conferma': //POST prenotazione/conferma
               
                if($vPrenotazione->recuperaValore('id')==='modifica') // recupero l'azione che ho dovuto inserire in id poichè ho una regola che mi si sovrappone
                {
                    //siamo in POST prenotazione/conferma/modifica
                    $this->confermaModificaPrenotazione(); 
                }
                else
                {
                    $this->confermaPrenotazione();
                }
                break;
                
            
            case 'riepilogo':   //controllato
                $vPrenotazione = USingleton::getInstance('VPrenotazione');
                try
                {
                    $this->riepilogoPrenotazione();
                }
                catch (XDBException $e)
                {
                    $errore = "C'è stato un errore nel sistema. Non è stata inserita alcuna prenotazione.";
                    $vPrenotazione->visualizzaFeedback($errore);
                    //Se c'è un errore durante l'esecuzione della query
                }
                catch (XRecuperaVAloreException $e)
                {
                    $errore = "Il valore inserito per la prenotazione è inesistente. Non è stata inserita alcuna prenotazione.";
                    $vPrenotazione->visualizzaFeedback($errore);
                    // Se il valore è inesistente
                }
                catch (XEsameException $e)
                {
                    $errore = "Esame inesistente. Non è stata inserita alcuna prenotazione.";
                    $vPrenotazione->visualizzaFeedback($errore);
                    // Se l'esame non esiste
                }
                catch (XUserException $e)
                {
                    $errore = "User inesistente. Non è stata inserita alcuna prenotazione.";
                    $vPrenotazione->visualizzaFeedback($errore);
                    //Se la clinica o l'utente  è inesistente
                }
                break;
            
            case 'modifica':
                $vPrenotazione = USingleton::getInstance('VPrenotazione');
                $id = $vPrenotazione->recuperaValore('id');
                if($id !== FALSE)
                {
                    try {
                        $eseguita = $vPrenotazione->recuperaValore('eseguita');
                       
                        $ePrenotazione = new EPrenotazione($id);
                        $risultato = $ePrenotazione->modificaEseguitaPrenotazione($eseguita);
                        $vJSON = USingleton::getInstance('VJSON');
                        if($risultato===TRUE)
                        {
                            if($ePrenotazione->getEseguitaPrenotazione()==TRUE)
                            {
                                $vJSON->inviaDatiJSON('ok'); 
                            }
                            else 
                            {
                                $vJSON->inviaDatiJSON('no');
                                
                            }
                            
                        }
                        else
                        {
                            $vJSON->inviaDatiJSON('no');
                        }
                    } 
                    catch (XPrenotazioneException $ex) {
                        $vPrenotazione->visualizzaFeedback('Prenotazione Inesistente. Non è stato posssibile modificare la prenotazione');
                        
                    }
                    catch (XDBException  $ex) {
                        $vPrenotazione->visualizzaFeedback('Si è verificato un errore. Non è stato possibile modificare la prenotazione');
                        
                    }
                    
                    
                }
                else
                    {
                        $vPrenotazione->visualizzaFeedback("C'è stato un errore, non è stato possibile modificare la prenotazione");
                    }
                break;
            default:
                break;
        }
    }
    
    
    /**     
     * Metodo che consente di eliminare un prenotazione se l'esame per questa prenotazione non è già stata eseguita.
     * 
     * @access public
     * @throws XValoreInesistenteException Se l'id della prenotazione è presente in $_REQUEST
     * @throws XPrenotazioneException Se la prenotazione con l'id passato come parametro non è stata trovata
     * @throws XPrenotazioneException Se la prenotazione è già eseguita
     * @throws XDBException Se la query per eliminare la prenotazione specificata non è stata eseguita con successo
     * @throws XUtenteException Se l'utente non esiste 
     * @throws XEsameException Se l'esame non esiste 
     * @throws XClinicaException Se la clinica  è inesistente
     * @throws XMailException Se l'email non è inviata
     */
    public function eliminaPrenotazione() 
    {
        $vPrenotazione = USingleton::getInstance('Vprenotazione');
        if (($idPrenotazione = $vPrenotazione->recuperaValore('id')) !== FALSE) 
        {
            $ePrenotazione = new EPrenotazione($idPrenotazione);
            if ($ePrenotazione->eliminaPrenotazione() === TRUE) {// se l'eliminazione è avvenuta con successo
                $sessione = USingleton::getInstance('USession');
                $tipo = $sessione->leggiVariabileSessione('tipoUser');
                if ($tipo !== 'utente') {
                    $codiceFiscaleUtente = $ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione();
                    $eUtente = new EUtente($codiceFiscaleUtente);
                    $eEsame = new EEsame($ePrenotazione->getIDEsamePrenotazione());
                    $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                    $datiPerEmail = Array('emailDestinatario' => $eUtente->getEmailUser(), 'nome' => $eUtente->getNomeUtente(),
                        'cognome' => $eUtente->getCognomeUtente(), 'nomeEsame' => $eEsame->getNomeEsameEsame(),
                        'nomeClinica' => $eClinica->getNomeClinicaClinica(), 'dataEOra' => $ePrenotazione->getDataEOraPrenotazione());
                    $mail = USingleton::getInstance('UMail'); 
                    if($mail->inviaEmailPrenotazioneCancellata($datiPerEmail))
                    {
                        $messaggio[1]= "L'utente è stato avvisato con un'email dell'avvenuta eliminazione della prenotazione.";                      
                    }
                    else 
                    {
                        $messaggio[1]="Ci spiace, non è stato possibile inviare un'email all'utente.";
                        $messaggio[2]="Contatti l'utente per avvertirlo dell'avvenuta eliminazione della prenotazione.";               
                    }
                }
//                $vPrenotazione->prenotazioneEliminata(TRUE, TRUE);
                $messaggio[0] = 'La prenotazione è stata eliminata con successo.';
                $vPrenotazione->visualizzaFeedback($messaggio);
            } else {
                $vPrenotazione->visualizzaFeedback("C'è stato un errore. Non è stato possibile eliminare la prenotazione.");
//                $vPrenotazione->prenotazioneEliminata(FALSE);
            }
        } else {// non c'è l'id
            
            throw new XValoreInesistenteException('id inesistente');
        }
    }

    
    /**
     * Metodo che consente di recuperare gli orari disponibili della clinica passata nell'url
     * per l'esame passato nell'url.
     * 
     * @access private
     */
    private function recuperaEInviaOrariDisponibili() {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $orariDisponibili = Array();
        $partitaIVAClinica = $vPrenotazione->recuperaValore('clinica');
        try {
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $workingPlan = $eClinica->getArrayWorkingPlanClinica(); 
            $nomeGiorno = $vPrenotazione->recuperaValore('giorno');
            if (($workingPlan[$nomeGiorno]) !== NULL) 
            {
                $id = $vPrenotazione->recuperaValore('id');
                $eEsame = new EEsame($id);
                $orariDisponibili = $eClinica->calcoloOrariDisponibili($eEsame, $workingPlan[$nomeGiorno]);
            }
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON($orariDisponibili);
        } catch (XClinicaException $ex) {
            $vPrenotazione->visualizzaFeedback("C'è stato un errore. Se l'errore si ripresenta, contatti l'amministratore.");
        }
        catch (XEsameException $ex) {
            $vPrenotazione->visualizzaFeedback("C'è stato un errore. Se l'errore si ripresenta, contatti l'amministratore.");
        }
        catch (XDBException $ex) {
            $vPrenotazione->visualizzaFeedback("C'è stato un errore. Se l'errore si ripresenta, contatti l'amministratore.");
        }
        
    }
    
    /**
     * Metodo che consente di visualizzare le prenotazioni. 
     * Nel caso ci fossero errori o eccezioni lanciate dalla funzione visualizzaPrenotazioni(), le gestisce.
     * 
     * @access public
     */
    public function tryVisualizzaPrenotazioni() 
    {
        $sessione = USingleton::getInstance('USession');       
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        try
        {
            $this->visualizzaPrenotazioni();
        }
        catch(XUserException $e)
        {
            $vPrenotazioni->visualizzaFeedback("C'è stato un errore. Se l'errore si ripresenta, contatti l'amministratore.");
        }
        catch(XDBException $e)
        {
            $vPrenotazioni->visualizzaFeedback("C'è stato un errore. Se l'errore si ripresenta, contatti l'amministratore.");
        } 
    }
    
    
    /**
     * Metodo che consente di visualizzare tutte le prenotazioni di una clinica o di un utente o di un medico.
     * 
     * @access private
     * @throws XClinicaException Se la clinica non esiste
     * @throws XMedicoException Se l'utente non esiste
     * @throws XUtenteException Se l'utente non esiste
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    private function visualizzaPrenotazioni()                                   //controllato
    {
        //visualizza tutte le prenotazioni  
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        $sessione = USingleton::getInstance('USession');        
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');        
        switch ($tipoUser) {
            case 'utente':
                $eUser = new EUtente(NULL, $username); //lancia XUtenteException
                break;
            case 'medico':
                $eUser = new EMedico(NULL, $username);// lancia XMedicoException
                break;
            case 'clinica':
                $eUser = new EClinica($username); // lancia XClinicaException
                break;
        }
        $prenotazioni = $eUser->cercaPrenotazioni(); // EUser può essere un utente, un medico o una clinica, 
        if (is_array($prenotazioni) && count($prenotazioni)>0) 
        {
            $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser, $prenotazioni);
        } 
        else 
        {
            //non sono presenti prenotazioni
            $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser);
        }
    }
    
    /**
     * Metodo che consente di effettuare il riepilogo della prenotazione se possibile.Infatti, 
     * l'applicazione non permette ad un utente di prenotarsi per uno stesso esame lo stesso giorno nella stessa clinica 
     * e di prenotarsi per qualsiasi esame in una qualsiasi clinica durante l'orario di un esame già prenotato da lui.
     * 
     * @access private
     * @throws XDBException Se c'è un errore durante l'esecuzione della query
     * @throws XUtenteException Se l'utente non esiste
     * @throws XClinicaException Se la clinica  è inesistente
     * @throws XEsameException Se l'esame non esiste
     * @throws XRecuperaVAloreException Se il valore è inesistente
     */
    private function riepilogoPrenotazione() {
        $sessione = USingleton::getInstance('USession');
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $idEsame = $vPrenotazione->recuperaValore('id'); // devo inserire 1 if???      
        $eEsame = new EEsame($idEsame);// throws XEsameException Se l'esame non esiste
        $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
        $eClinica = new EClinica(NULL, $partitaIVAClinica); //throws XClinicaException Se la clinica  è inesistente
        $data = $vPrenotazione->recuperaValore('data'); // throws XRecuperaVAloreException Se il valore è inesistente
        $orario = $vPrenotazione->recuperaValore('orario');// throws XRecuperaVAloreException Se il valore è inesistente
        $durata = $vPrenotazione->recuperaValore('durata');// throws XRecuperaVAloreException Se il valore è inesistente
        if ($sessione->leggiVariabileSessione('tipoUser') === 'utente') {
            $eUtente = new EUtente(NULL, $username); //throws XUtenteException Se l'utente non esiste
            $codice = $eUtente->getCodFiscaleUtente();
        } else {  // tipoUser = clinica o medico
            $codice = $vPrenotazione->recuperaValore('codice'); // throws XRecuperaVAloreException Se il valore è inesistente
            $eUtente = new EUtente($codice);        //throws XUtenteException Se l'utente non esiste               
        }
        $modifica = $vPrenotazione->recuperaValore('modifica');
        
        if ($eUtente->checkIfCan($idEsame, $partitaIVAClinica, $data, $orario, $durata, $modifica) === TRUE) { //@throws XDBException Se c'è un errore durante l'esecuzione della query
            if ($modifica==='true' || $modifica==='1')
            { 
                $idPrenotazione = $vPrenotazione->recuperaValore('idPrenotazione');  
                $vPrenotazione->restituisciPaginaRiepilogoPrenotazione(NULL, $eEsame, $eClinica, $eUtente, $data, $orario, $codice, $modifica, $idPrenotazione);
            }
            else
            {
                $modifica = FALSE; // sovrascrivo il false con FALSE in maniera che non ci siano problemi con smarty
                $vPrenotazione->restituisciPaginaRiepilogoPrenotazione(NULL, $eEsame, $eClinica, $eUtente, $data, $orario, $codice, $modifica);
            }
            
        } 
        else {
            if($sessione->leggiVariabileSessione('tipoUser') === 'utente')
            {
                $feedback[0] = "Non puoi effettuare questa prenotazione.";
                $feedback[1] = "Hai già una prenotazione per questo esame o hai una prenotazione durante l'orario di questo esame.";
            }
            else
            {
                $feedback[0] = "Non puoi effettuare questa prenotazione.";
                $feedback[1]= "L'utente ha già una prenotazione per questo esame o ha una prenotazione durante l'orario di questo esame.";
            }
            
            $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($feedback);
        }
    }
    
    /**
     * Metodo che consente di ottenere la pagina per la modifica di una prenotazione se la data di prenotazione è successiva a quella odierna e di ieri
     * 
     * @access private
     * @param string $idPrenotazione L'id della prenotazione da modificare
     * @throws XPrenotazioneException Se la prenotazione con l'id passato come parametro non è stata trovata
     * @throws XEsameException Se l'esame non esiste
     * @throws XClinicaException Se la clinica è inesistente
     */
    private function modificaPrenotazione($idPrenotazione) 
    {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $ePrenotazione= new EPrenotazione($idPrenotazione);
        $sessione = USingleton::getInstance('USession');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        if($ePrenotazione->controllaData()==TRUE && $ePrenotazione->getEseguitaPrenotazione()==FALSE)// confronta la data della prenotazione con quella odierna; TRUE se la data odierna è precedente a quella dela prenotazione // controllo anche che non sia stata effettuata la prenptazione(anche se la data è futura non potrà essere eseguita)
        {
            $idEsame = $ePrenotazione->getIDEsamePrenotazione();
            $eEsame = new EEsame($idEsame);
            $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $nomeEsame = $eEsame->getNomeEsameEsame();
            $durataEsame = $eEsame->getDurataEsame();
            $nomeClinica = $eClinica->getNomeClinicaClinica();
            $codiceFiscale = $ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione();
            $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $idEsame, $durataEsame, $codiceFiscale, $tipoUser);
        }
        else {
            $messaggio = 'Non è possibile modificare la data della prenotazione a partire dal giorno precedente la data di prenotazione';
            $vPrenotazione->visualizzaFeedback($messaggio);

        }
    }
    
    /**
     * Metodo che consente di ottenere la pagina per la modifica gestendo tutti gli errori ed eccezioni.
     * 
     * @access public
     */
    public function tryModificaPrenotazione() {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $idPrenotazione = $vPrenotazione->recuperaValore('id'); 
        if(isset($idPrenotazione) && $idPrenotazione!==FALSE)// GET prenotazione/modifica/idPrenotazione
        {
            try 
            {
                $this->modificaPrenotazione($idPrenotazione);
            } 
            catch (XPrenotazioneException $ex) 
            {
                $messaggio = "La prenotazione inesistente";
                $vPrenotazione->visualizzaFeedback($messaggio);
            }
            catch (XEsameException $ex) 
            {
                $messaggio = "Esame inesistente."; // Se l'esame non esiste
                $vPrenotazione->visualizzaFeedback($messaggio);
            }
            catch (XClinicaException $ex) 
            {
                $messaggio = "Clinica inesistente."; // Se la clinica non esiste
                $vPrenotazione->visualizzaFeedback($messaggio);
            }
            catch (XDBException $ex) 
            {
                $messaggio = "C'è stato un errore."; // Se la clinica non esiste
                $vPrenotazione->visualizzaFeedback($messaggio);
            }
        }                    
        else
        {
            $messaggio = "C'è stato un errore. Non è stato trovato l'id della prenotazione";
            $vPrenotazione->visualizzaFeedback($messaggio);
        }
    }
    
    /**
     * Metodo che cerca tutte le prenotazioni da effettuare in una determinata
     * data passata come parametro. Per ogni prenotazione trovata invia una mail
     * per ricordare all'utente la prenotazione.  Non c'è il passaggio attraverso l'entità.
     * 
     * @access public
     * @param date $data La data in formato d-m-Y
     */
    public function cercaPrenotazioniEInviaMemoPrenotazione($data) {
        // non c'è il passaggio attraverso l'entità per trovare tutte le prenotazioni 
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        $prenotazioni = $fPrenotazioni->cercaPrenotazioniData($data);
        foreach ($prenotazioni as $prenotazione) {
            $infoPrenotazione;
            foreach ($prenotazione as $key => $value) {
                switch ($key) {
                    case 'IDEsame':
                        $eEsame = new EEsame($value);
                        $infoPrenotazione['nomeEsame'] = $eEsame->getNomeEsameEsame();
                        break;
                    
                    case 'PartitaIVAClinica':
                        $eClinica = new EClinica(NULL, $value);
                        $infoPrenotazione['nomeClinica'] = $eClinica->getNomeClinicaClinica();
                        $infoPrenotazione['indirizzoClinica'] = $eClinica->getIndirizzoClinica();
                        break;
                    
                    case 'CodFiscaleUtenteEffettuaEsame':
                        $eUtente = new EUtente($value);
                        $infoPrenotazione['nomeUtente'] = $eUtente->getNomeUtente();
                        $infoPrenotazione['cognomeUtente'] = $eUtente->getCognomeUtente();
                        $infoPrenotazione['email'] = $eUtente->getEmailUser();
                        break;
                    
                    case 'DataEOra':
                        $data = strtotime(substr($value, 0, 10));
                        $infoPrenotazione['data'] = date('d-m-Y', $data);
                        $infoPrenotazione['ora'] = substr($value, 11,5);
                        break;
                    default:
                        break;
                }
                
            }
            // ora ho tutte le info per inviare una mail di memo ad un utente per una prenotazione
            $mail = USingleton::getInstance('UMail');
            if($mail->inviaMailMemoPrenotazione($infoPrenotazione)=== FALSE)
            {
                return FALSE;
            }; // se la mail non è stata inviata che si fa?
         
        }
    }
    
    /**
     * Metodo che consente di confermare la prenotazione.
     * 
     * @access private
     */
    private function confermaPrenotazione() {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $sessione = USingleton::getInstance('USession');
        $tipo = $sessione->leggiVariabileSessione('tipoUser');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        try {
            switch ($tipo) {
            case 'utente':
                $eUtente = new EUtente(NULL, $username);                
                $codFiscalePrenotaEsame = $eUtente->getCodFiscaleUtente();
                break;

            case 'medico':
                $eMedico = new EMedico(NULL, $username);
                $codFiscalePrenotaEsame = $eMedico->getCodFiscaleMedico();
                break;

            case 'clinica':
                $codFiscalePrenotaEsame = $vPrenotazione->recuperaValore('codice');

                break;
            default:
                break;
            }
            $codFiscaleUtenteEffettuaEsame = $vPrenotazione->recuperaValore('codice');
            if (!isset($eUtente)) {
                $eUtente = new EUtente($codFiscaleUtenteEffettuaEsame);
            }
            $idEsame = $vPrenotazione->recuperaValore('id');
            $eEsame = new EEsame($idEsame);
            $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
            $data = $vPrenotazione->recuperaValore('data');
            $ora = $vPrenotazione->recuperaValore('orario');
            $dataEOra = $data . " " . $ora;
            $ePrenotazione = new EPrenotazione(NULL, $idEsame, $tipo, $codFiscaleUtenteEffettuaEsame, $codFiscalePrenotaEsame, $dataEOra);
            $risultatoQuery = $ePrenotazione->aggiungiPrenotazioneDB();
            if($risultatoQuery){
                $messaggio[0] = 'Appuntamento registrato con successo.';
                $datiPerEmail = Array('email' => $eUtente->getEmailUser(), 'nomeUtente' => $eUtente->getNomeUtente(),
                            'cognomeUtente' => $eUtente->getCognomeUtente(), 'nomeEsame' => $eEsame->getNomeEsameEsame(),
                            'nomeClinica' => $eClinica->getNomeClinicaClinica(), 'data' => $data, 'ora' => $ora, 'indirizzoClinica' => $eClinica->getIndirizzoClinica());
                $mail = USingleton::getInstance('UMail'); 
                        if($mail->inviaEmailPrenotazione($datiPerEmail))
                        {
                            if($tipo !=='utente'){
                                $messaggio[1]= "L'utente è stato avvisato con un'email dell'avvenuta prenotazione.";    
                            }
                        }
                        else 
                        {
                            $messaggio[1]="Ci spiace, non è stato possibile inviare un'email all'utente.";
                            $messaggio[2]="Contatti l'utente per avvertirlo dell'avvenuta prenotazione.";               
                        }

            }
            else{
                $messaggio[0] = "C'è stato un problema, il tuo appuntamento non è stato registrato.";
            }                    
            $vPrenotazione->visualizzaFeedback($messaggio);
    //                    $vPrenotazione->appuntamentoAggiunto($risultatoQuery);
        } catch (XUserException $ex) {
            $messaggio[0] = "C'è stato un problema, il tuo appuntamento non è stato registrato.";
            $vPrenotazione->visualizzaFeedback($messaggio);
        }
        catch (XEsameException $ex) {
            $messaggio[0] = "C'è stato un problema, il tuo appuntamento non è stato registrato.";
            $vPrenotazione->visualizzaFeedback($messaggio);
        }
        catch (XPrenotazioneException $ex) {
            $messaggio[0] = "C'è stato un problema, il tuo appuntamento non è stato registrato.";
            $vPrenotazione->visualizzaFeedback($messaggio);
        }
        catch (XDBException $ex) {
            $messaggio[0] = "C'è stato un problema, il tuo appuntamento non è stato registrato.";
            $vPrenotazione->visualizzaFeedback($messaggio);
        }
        
    }
    
    /**
     * Metodo che consente di confermare la modifica di una prenotazione gestendo le eventuali eccezioni.
     * 
     * @access private
     */
    private function confermaModificaPrenotazione() {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        try{
            $idPrenotazione = $vPrenotazione->recuperaValore('idPrenotazione');// throw errore se non c'è valore
            $ePrenotazione = new EPrenotazione($idPrenotazione);// throw se non esiste la prenotazione
            $ora = $vPrenotazione->recuperaValore('orario');//
            $data = $vPrenotazione->recuperaValore('data');//
            if($ePrenotazione->modificaPrenotazione($data, $ora))//@throws XDBException Se la query non è stata eseguita con successo
            {
                $errore = "Prenotazione modificata!";                     
            }
            else
            {
                $errore = "Prenotazione non modificata!"; 
            }

            $vPrenotazione->visualizzaFeedback($errore);
        }  
        catch (XDBException $e)
        {
            $errore = $e->getMessage() . " C'è stato un errore. Non è stato possibile effettuare alcuna modifica";
            $vPrenotazione->visualizzaFeedback($errore);
        }
        catch(XValoreInesistenteException $e)
        {
            $errore = "Valore inesistente. Non è stato possibile effettuare alcuna modifica";
            $vPrenotazione->visualizzaFeedback($errore);
        }
        catch(XPrenotazioneException  $e)
        {
            $errore = "Prenotazione inesistente. Non è stato possibile effettuare alcuna modifica";
            $vPrenotazione->visualizzaFeedback($errore);
        }
    }
    
    /**
     * 
     * @access private
     * @param type $idPrenotazione
     */
    private function tryVisualizzaPrenotazione($idPrenotazione){
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        $sessione = USingleton::getInstance('USession');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        try {
                $ePrenotazione = new EPrenotazione($idPrenotazione);
                $idEsame = $ePrenotazione->getIDEsamePrenotazione();
                $eEsame = new EEsame($idEsame);
                $nomeEsame = $eEsame->getNomeEsameEsame();
                $medicoEsame = $eEsame->getMedicoEsameEsame();
                try{
                    $eReferto = new EReferto($ePrenotazione->getIDPrenotazionePrenotazione());
                    $idReferto = $eReferto->getIDRefertoReferto(); 
                } 
                catch (XRefertoException $e)
                {
                    $idReferto = NULL;
                }
                if ($tipoUser !== 'clinica')
                {
                  $partitaIVA = $eEsame->getPartitaIVAClinicaEsame();
                  $eClinica = new EClinica(NULL, $partitaIVA);  // potrebbe lanciare XClinicaException('Clinica inesistente')                      
                }
                $cancellaPrenota = $ePrenotazione->controllaData();
                switch ($tipoUser) {
                    case 'utente':
                        if($ePrenotazione->getTipoPrenotazione()==='U')
                        {
                            $cfUtentePrenotaEsame = $ePrenotazione->getCodFiscaleUtentePrenotaEsamePrenotazione();
                            if(isset($cfUtentePrenotaEsame))
                            {
                                $eUtente = new EUtente($cfUtentePrenotaEsame);

                            }
                            else // caso in cui l'utente che ha prenotato l'esame viene eliminato dal sistema
                            {
                                $codFiscaleUtente = $ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione();
                                $ePrenotazione->setUtentePrenotaEsamePrenotazione($codFiscaleUtente);
                                $eUtente = new EUtente($codFiscaleUtente);        
                            }
                            $nome = $eUtente->getNomeUtente();
                            $cognome = $eUtente->getCognomeUtente();
                        }
                        else
                        {
                            $cfMedico = $ePrenotazione->getCodFiscaleMedicoPrenotaEsamePrenotazione();
                            if(isset($cfMedico))
                            {
                                $eMedico = new EMedico($ePrenotazione->getCodFiscaleMedicoPrenotaEsamePrenotazione());
                                $nome = $eMedico->getNomeMedico();
                                $cognome = $eMedico->getCognomeMedico();
                            }
                            else // caso in cui il medico che ha effettuato la prenotazione è stato cancellato
                            {
                                $ePrenotazione->setTipoPrenotazione('U');
                                $codFiscaleUtente = $ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione();
                                $ePrenotazione->setUtentePrenotaEsamePrenotazione($codFiscaleUtente);
                                $eUtente = new EUtente($codFiscaleUtente);
                                $nome = $eUtente->getNomeUtente();
                                $cognome = $eUtente->getCognomeUtente();
                            }
                        }
                        $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione,  NULL, NULL, $nomeEsame, $medicoEsame,$tipoUser, $eClinica, $idReferto, $nome, $cognome,$cancellaPrenota);
                        break;

                    case 'medico':
                            $eUtente = new EUtente($ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione()); // potrebbe lanciare UtenteException('Utente non esistente')
                            $nome = $eUtente->getNomeUtente();
                            $cognome = $eUtente->getCognomeUtente(); 
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nome, $cognome, $nomeEsame, $medicoEsame, $tipoUser, $eClinica, $idReferto, NULL, NULL,FALSE) ;
                        break;

                    case 'clinica': 
                        $CFUtente = $ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione();
                        $eUtente = new EUtente($CFUtente);
                        $nomeUtente = $eUtente->getNomeUtente();
                        $cognomeUtente = $eUtente->getCognomeUtente();                       
                        $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nomeUtente, $cognomeUtente, $nomeEsame, $medicoEsame, $tipoUser, NULL, $idReferto, NULL, NULL, $cancellaPrenota);
                        break;



                    default:
                        $vPrenotazioni->visualizzaFeedback("C'è stato un errore. Non è stato possibile recuperate la prenotazione");
                        break;

                    }
                } 
                catch (XPrenotazioneException $ex) {
                    $vPrenotazioni->visualizzaFeedback($ex->getMessage());
                }
                catch (XEsameException $ex) {
                    $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni(NULL, NULL, TRUE);
                }
                catch (XClinicaException $ex) {
                    
                    $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni(NULL, NULL, TRUE);
                }
                catch (XUtenteException $ex) {
                    
                    $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni(NULL, NULL, TRUE);
                }
                catch (XMedicoException $ex) {
                    $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni(NULL, NULL, TRUE);
                    
                }
    }
}

