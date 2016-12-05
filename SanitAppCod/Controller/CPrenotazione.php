<?php

/**
 * Description of CPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CPrenotazione {

    /**
     * Metodo che consente di gestire una prenotazione
     */
    public function gestisciPrenotazione() {
        $orari = Array();
        $date;
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
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
                    
                }
                break;
                
                case 'esame':// GET prenotazione/esame
                    $id = $vPrenotazione->recuperaValore('id'); 
                    if(isset($id))// GET prenotazione/esame/idEsame
                    {
                        $eEsame = new EEsame($id);
                        $partitaIVAClinica = $eEsame->getPartitaIVAClinicaEsame();
                        $eClinica = new EClinica(NULL, $partitaIVAClinica);
                        $nomeEsame = $eEsame->getNomeEsame();
                        $durataEsame = $eEsame->getDurataEsame();
                        $nomeClinica = $eClinica->getNomeClinica();
                        $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $id, $durataEsame);
                    }
                    break;
                
                case 'modifica': 
                    $this->tryModificaPrenotazione();
                    
                    break;

                

                default:
                    echo "erroe";
                    break;
            }
        } 
        else 
        {
            $orariDisponibili = Array();
            $partitaIVAClinica = $vPrenotazione->recuperaValore('clinica');
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $workingPlan = $eClinica->getWorkingPlanClinica(); // ora è di tipo json

//            $workingPlan = json_decode($workingPlan);
//                  print_r($workingPlan);
//            //$workingPlan è un oggetto 
//            // ora lo rendo un array
//            $workingPlan = get_object_vars($workingPlan);
//            print_r($workingPlan);
            $nomeGiorno = $vPrenotazione->recuperaValore('giorno');
            if (($workingPlan[$nomeGiorno]) !== NULL) 
            {
                $id = $vPrenotazione->recuperaValore('id');
                $eEsame = new EEsame($id);
                $orariDisponibili = $eClinica->calcoloOrariDisponibili($eEsame, $workingPlan[$nomeGiorno], $vPrenotazione);
            }
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON($orariDisponibili);
        }
    }

    

    public function gestisciPrenotazioni() 
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        $task = $vPrenotazioni->getTask();
//        $codiceFiscaleUtente = "";
        switch ($task) {                
            case 'visualizza':
            $idPrenotazione = $vPrenotazioni->recuperaValore('id');
            if ($idPrenotazione === FALSE)
            {
                $this->tryVisualizzaPrenotazioni();
            }
            else
            {
                $ePrenotazione = new EPrenotazione($idPrenotazione); // potrebbe lanciare PrenotazioneException('Prenotazione non trovata');
                $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                $eEsame = new EEsame($idEsame); // potrebbe lanciare EsameException('Esame non esistente')
                $nomeEsame = $eEsame->getNomeEsame();
                $medicoEsame = $eEsame->getMedicoEsame();
                $eReferto = new EReferto($ePrenotazione->getIdPrenotazione(), $ePrenotazione->getPartitaIVAPrenotazione(),$idEsame);
                $idReferto = $eReferto->getIDReferto();  
                if ($tipoUser !== 'clinica')
                {
                  $partitaIVA = $ePrenotazione->getPartitaIVAPrenotazione();
                  $eClinica = new EClinica(NULL, $partitaIVA);  // potrebbe lanciare XClinicaException('Clinica inesistente')                      
                }
                $cancellaPrenota = $ePrenotazione->controllaData();
                switch ($tipoUser) {
                    case 'utente':
                        if($ePrenotazione->getTipoPrenotazione()==='U')
                        {
                            $eUtente = new EUtente($ePrenotazione->getUtentePrenotaEsamePrenotazione());
                            $nome = $eUtente->getNomeUtente();
                            $cognome = $eUtente->getCognomeUtente();
                        }
                        else
                        {
                            $eMedico = new EMedico($ePrenotazione->getMedicoPrenotaEsamePrenotazione());
                            $nome = $eMedico->getNomeMedico();
                            $cognome = $eMedico->getCognomeMedico();
                        }
                        $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione,  NULL, NULL, $nomeEsame, $medicoEsame,$tipoUser, $eClinica, $idReferto, $nome, $cognome,$cancellaPrenota);
                        break;
                    
                    case 'medico':
    
                            $eUtente = new EUtente($ePrenotazione->getUtenteEffettuaEsamePrenotazione()); // potrebbe lanciare UtenteException('Utente non esistente')
                            $nome = $eUtente->getNomeUtente();
                            $cognome = $eUtente->getCognomeUtente(); 
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nome, $cognome, $nomeEsame, $medicoEsame, $tipoUser, $eClinica, $idReferto, NULL, NULL,$cancellaPrenota) ;
                        break;
                    
                    case 'clinica': 
                        $CFUtente = $ePrenotazione->getUtenteEffettuaEsamePrenotazione();
                        $eUtente = new EUtente($CFUtente);
                        $nomeUtente = $eUtente->getNomeUtente();
                        $cognomeUtente = $eUtente->getCognomeUtente();                       
                        $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nomeUtente, $cognomeUtente, $nomeEsame, $medicoEsame, $tipoUser, NULL, $idReferto, NULL, NULL, $cancellaPrenota);
                        break;
                    
                                   

                    default:
                        $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni(NULL, NULL, TRUE);
                        break;
                }
            }



                break;

//            case 'aggiungi':
//                $vPrenotazioni->restituisciPaginaAggiungiPrenotazione();
//                break;
                    case 'aggiungi':
                        switch ($tipoUser) 
                        {
                            case 'clinica':
                                $eClinica = new EClinica($username);
                                $nomeClinica = $eClinica->getNomeClinica();
                                // visualizzo una pagina per cercare il cliente o l'utente registrato del sistema per cui in seguito vorrò effettuare una prenotazione
                                $vPrenotazioni->impostaPaginaCercaUtente($nomeClinica, 'clinica');
                                break;
                            
                            case 'medico':
                                $eMedico= new EMedico(NULL, $username);
                                $vPrenotazioni->impostaPaginaCercaUtente($eMedico->getCodiceFiscaleMedico(), 'medico');
                            
                            default:
                                break;
                        }
            default:
                break;
        }
    }

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
            
            case 'conferma':
               
                if($vPrenotazione->recuperaValore('id')==='modifica') // recupero l'azione che ho dovuto inserire in id ppoichè ho una regola che mi si sovrappone
                {
                    echo "in modifica";
                    //siamo in POST prenotazione/conferma/modifica
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
                else
                {
                    echo "in else";
                    $sessione = USingleton::getInstance('USession');
                    $tipo = $sessione->leggiVariabileSessione('tipoUser');
                    $username = $sessione->leggiVariabileSessione('usernameLogIn');
                    switch ($tipo) {
                        case 'utente':
                            $eUtente = new EUtente(NULL, $username);
                            $codFiscaleUtenteEffettuaEsame = $vPrenotazione->recuperaValore('codice');
                            $codFiscalePrenotaEsame = $eUtente->getCodiceFiscaleUtente();
                            break;

                        case 'medico':
                            echo "l'username $username";
                            $eMedico = new EMedico(NULL, $username);
                            $codFiscalePrenotaEsame = $eMedico->getCodiceFiscaleMedico();
                            $codFiscaleUtenteEffettuaEsame = $vPrenotazione->recuperaValore('codice');
                            break;

                        case 'clinica':
                            $codFiscalePrenotaEsame = $vPrenotazione->recuperaValore('codice');
                            $codFiscaleUtenteEffettuaEsame = $vPrenotazione->recuperaValore('codice');

                            break;
                        default:
                            break;
                    }
                    $idEsame = $vPrenotazione->recuperaValore('id');
                    $partitaIVAClinica = $vPrenotazione->recuperaValore('clinica');
                    $data = $vPrenotazione->recuperaValore('data');
                    $ora = $vPrenotazione->recuperaValore('orario');
                    $dataEOra = $data . " " . $ora;
                    $ePrenotazione = new EPrenotazione(NULL, $idEsame, $partitaIVAClinica, $tipo, $codFiscaleUtenteEffettuaEsame, $codFiscalePrenotaEsame, $dataEOra);

                    $risultatoQuery = $ePrenotazione->aggiungiPrenotazioneDB();
                    $vPrenotazione->appuntamentoAggiunto($risultatoQuery);
                }
                break;
                
            
            case 'riepilogo':
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
            
      
                
                break;
            default:
                break;
        }
    }
    
    
    /**     
     * Metodo che consente di eliminare un prenotazione se l'esame per questa prenotazione non è già stata eseguita
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
                    $codiceFiscaleUtente = $ePrenotazione->getUtenteEffettuaEsamePrenotazione();
                    $eUtente = new EUtente($codiceFiscaleUtente);
                    $eEsame = new EEsame($ePrenotazione->getIdEsamePrenotazione());
                    $eClinica = new EClinica(NULL, $ePrenotazione->getPartitaIVAPrenotazione());
                    $datiPerEmail = Array('emailDestinatario' => $eUtente->getEmail(), 'nome' => $eUtente->getNomeUtente(),
                        'cognome' => $eUtente->getCognomeUtente(), 'nomeEsame' => $eEsame->getNomeEsame(),
                        'nomeClinica' => $eClinica->getNomeClinica(), 'dataEOra' => $ePrenotazione->getDataEOra());
                    $mail = USingleton::getInstance('UMail');
                    $mail->inviaEmailPrenotazioneCancellata($datiPerEmail);
                }
                $vPrenotazione->prenotazioneEliminata(TRUE, TRUE);
            } else {
                $vPrenotazione->prenotazioneEliminata(FALSE);
            }
        } else {// non c'è l'id
            
            throw new XValoreInesistenteException('id inesistente');
        }
    }

    
    
    
    
    
    
    
    
    
    
    // funzione da eliminare una volta visti e catturati tutti gli errori 
    public function visualizzaPrenotazioneOPrenotazioni() {
        switch ($tipoUser) 
                {
                    case 'utente':
                        $idPrenotazione = $vPrenotazioni->recuperaValore('id');
                        if ($idPrenotazione === FALSE) 
                        {
                            try
                            {
                                //visualizza tutte le prenotazioni 
                                $this->visualizzaPrenotazioniUtente();
                            }
                            catch(XUtenteException $e)
                            {
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser, NULL, TRUE);
                            }
                            catch(XDBException $e)
                            {
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser, NULL, $e->getMessage() );
                            }                            
                        } 
                        else {
                            // attenzione controllare la progettazione di  Prenotazione
                            $ePrenotazione = new EPrenotazione($idPrenotazione);
                            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                            $eEsame = new EEsame($idEsame);
                            $nomeEsame = $eEsame->getNomeEsame();
                            $medicoEsame = $eEsame->getMedicoEsame();
                            $partitaIVA = $ePrenotazione->getPartitaIVAPrenotazione();
                            $eClinica = new EClinica(NULL, $partitaIVA);
                            if($ePrenotazione->getTipoPrenotazione()==='U')
                            {
                                $eUtente = new EUtente($ePrenotazione->getUtentePrenotaEsamePrenotazione());
                                $nome = $eUtente->getNomeUtente();
                                $cognome = $eUtente->getCognomeUtente();
                            }
                            else
                            {
                                $eMedico = new EMedico($ePrenotazione->getMedicoPrenotaEsamePrenotazione());
                                $nome = $eMedico->getNomeMedico();
                                $cognome = $eMedico->getCognomeMedico();
                            }
                            $eReferto = new EReferto($ePrenotazione->getIdPrenotazione(),$ePrenotazione->getPartitaIVAPrenotazione(), $ePrenotazione->getIdEsamePrenotazione());
                            $idReferto = $eReferto->getIDReferto();
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione,  NULL, NULL, $nomeEsame, $medicoEsame,$tipoUser, $eClinica, $idReferto, $nome, $cognome);
                        }
                        break;
                        
                        case 'medico':
                        $idPrenotazione = $vPrenotazioni->recuperaValore('id');
                        if ($idPrenotazione === FALSE) 
                        {
                            //visualizza tutte le prenotazioni 
                            $this->visualizzaPrenotazioniMedico();
                        } 
                        else 
                        {
                            //visualizzare una sola prenotazione
                           
                            // attenzione controllare la progettazione di  Prenotazione
                            $ePrenotazione = new EPrenotazione($idPrenotazione); // potrebbe lanciare PrenotazioneException('Prenotazione non trovata');
                            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                            $eEsame = new EEsame($idEsame); // potrebbe lanciare EsameException('Esame non esistente')
                            $nomeEsame = $eEsame->getNomeEsame();
                            $medicoEsame = $eEsame->getMedicoEsame();
                            $partitaIVA = $ePrenotazione->getPartitaIVAPrenotazione();
                            $eClinica = new EClinica(NULL, $partitaIVA);  // potrebbe lanciare ClinicaException('Clinica inesistente')                      
                            $eUtente = new EUtente($ePrenotazione->getUtenteEffettuaEsamePrenotazione()); // potrebbe lanciare UtenteException('Utente non esistente')
                            $nome = $eUtente->getNomeUtente();
                            $cognome = $eUtente->getCognomeUtente();    
                            $eReferto = new EReferto($ePrenotazione->getIdPrenotazione(),$ePrenotazione->getPartitaIVAPrenotazione(), $ePrenotazione->getIdEsamePrenotazione());
                            $idReferto = $eReferto->getIDReferto();
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nome, $cognome, $nomeEsame, $medicoEsame, $tipoUser, $eClinica, $idReferto, NULL, NULL) ;
                        }
                        break;

                    case 'clinica':
                        
                        $idPrenotazione = $vPrenotazioni->recuperaValore('id');
                        if ($idPrenotazione === FALSE) //si vogliono visualizzare tutte le prenotazioni
                        {
                            try
                            {
                                //visualizza tutte le prenotazioni 
                                $this->visualizzaPrenotazioniClinica();
                            }
                            catch(XClinicaException $e)
                            {
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser, NULL, TRUE);
                            }
                            catch(XDBException $e)
                            {
                                $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser, NULL, $e->getMessage() );
                            }
                            
                        }
                        else // visualizza una sola prenotazione 
                        {                            
                            $ePrenotazione = new EPrenotazione($idPrenotazione);
                            $CFUtente = $ePrenotazione->getUtenteEffettuaEsamePrenotazione();
                            $eUtente = new EUtente($CFUtente);
                            $nomeUtente = $eUtente->getNomeUtente();
                            $cognomeUtente = $eUtente->getCognomeUtente();
                            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                            $eEsame = new EEsame($idEsame);
                            $nomeEsame = $eEsame->getNomeEsame();
                            $medicoEsame = $eEsame->getMedicoEsame();
                            $eReferto = new EReferto($ePrenotazione->getIdPrenotazione(), $ePrenotazione->getPartitaIVAPrenotazione(),$idEsame);
                            $idReferto = $eReferto->getIDReferto();
                            $vPrenotazioni->visualizzaInfoPrenotazione($ePrenotazione, $nomeUtente, $cognomeUtente, $nomeEsame, $medicoEsame, $tipoUser, NULL, $idReferto, NULL, NULL);
                        }
                        break;                        
                  

                    default:
                        $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni(NULL, NULL, TRUE);
                        break;
                }
        
    }
    
    /**
     * Metodo che consente di visualizzare le prenotazioni. Nel caso ci fossero errori o eccezioni, le gestisce
     * 
     * @access public
     */
    public function tryVisualizzaPrenotazioni() 
    {
        $sessione = USingleton::getInstance('USession');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');        
        $vPrenotazioni = USingleton::getInstance('VPrenotazione');
        try
                {
                    $this->visualizzaPrenotazioni();
                }
                catch(XUserException $e)
                {
                    $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser, NULL, TRUE);
                }
                catch(XDBException $e)
                {
                    $vPrenotazioni->restituisciPaginaRisultatoPrenotazioni($tipoUser, NULL, $e->getMessage() );
                } 
    }
    
    
    /**
     * Metodo che consente di visualizzare tutte le prenotazioni di una clinica o di un utente o di un medico
     * 
     * @access private
     * @throws XClinicaException Se la clinica non esiste
     * @throws XMedicoException Se l'utente non esiste
     * @throws XUtenteException Se l'utente non esiste
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    private function visualizzaPrenotazioni() 
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
            $codice = $eUtente->getCodiceFiscaleUtente();
        } else {  // tipoUser = clinica o medico
            $codice = $vPrenotazione->recuperaValore('codice'); // throws XRecuperaVAloreException Se il valore è inesistente
            $eUtente = new EUtente($codice);        //throws XUtenteException Se l'utente non esiste               
        }
        if ($eUtente->checkIfCan($idEsame, $partitaIVAClinica, $data, $orario, $durata) === TRUE) { //@throws XDBException Se c'è un errore durante l'esecuzione della query
            $modifica = $vPrenotazione->recuperaValore('modifica');
            print_r($modifica);
            if ($modifica===true || $modifica==='1')
            { 
                $idPrenotazione =  $vPrenotazione->recuperaValore('idPrenotazione');                
                $vPrenotazione->restituisciPaginaRiepilogoPrenotazione(NULL, $eEsame, $eClinica, $eUtente, $data, $orario, $codice, $modifica, $idPrenotazione);
            }
            else
            {
                $modifica = FALSE; // sovrascrivo il false con FALSE in maniera che non ci siano problemi con smarty
                $vPrenotazione->restituisciPaginaRiepilogoPrenotazione(NULL, $eEsame, $eClinica, $eUtente, $data, $orario, $codice, $modifica);
            }
            
        } else {
            $feedback = "Non puoi effettuare questa prenotazione.\n Hai già una prenotazione per questa esame  o  hai una prenotazione durante l'orario di questo esame";
            $vPrenotazione->restituisciPaginaRiepilogoPrenotazione($feedback);
        }
    }
    
    /**
     * Metodo che consente di ottenere la pagina per la modifica di una prenotazione se la data di prenotazione è successiva a quella odierna e di ieri
     * 
     * @access public
     * @param string $idPrenotazione L'id della prenotazione da modificare
     * @throws XPrenotazioneException Se la prenotazione con l'id passato come parametro non è stata trovata
     * @throws XEsameException Se l'esame non esiste
     * @throws XClinicaException Se la clinica è inesistente
     */
    public function modificaPrenotazione($idPrenotazione) 
    {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $ePrenotazione= new EPrenotazione($idPrenotazione);
        if($ePrenotazione->controllaData()===TRUE)// confronta la data della prenotazione con quella odierna; TRUE se la data odierna è precedente a quella dela prenotazione
        {
            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
            $eEsame = new EEsame($idEsame);
            $partitaIVAClinica = $ePrenotazione->getPartitaIVAPrenotazione();
            $eClinica = new EClinica(NULL, $partitaIVAClinica);
            $nomeEsame = $eEsame->getNomeEsame();
            $durataEsame = $eEsame->getDurataEsame();
            $nomeClinica = $eClinica->getNomeClinica();
            $codiceFiscale = $ePrenotazione->getUtenteEffettuaEsamePrenotazione();
            $vPrenotazione->restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $idEsame, $durataEsame, $codiceFiscale);
        }
        else {
            $messaggio = 'Non è possibile modificare la data della prenotazione a partire dal giorno precedente la data di prenotazione';
            $vPrenotazione->visualizzaFeedback($messaggio);

        }
    }
    
    /**
     * Metodo che consente di ottenere la pagina per la modifica gestendo tutti gli errori ed eccezioni
     * 
     * @access public
     */
    public function tryModificaPrenotazione() {
        $idPrenotazione = $vPrenotazione->recuperaValore('id'); 
        if(isset($idPrenotazione))// GET prenotazione/modifica/idPrenotazione
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
                $messaggio = "Esame inesistente"; // Se l'esame non esiste
                $vPrenotazione->visualizzaFeedback($messaggio);
            }
            catch (XClinicaException $ex) 
            {
                $messaggio = "Clinica inesistente"; // Se la clinica non esiste
                $vPrenotazione->visualizzaFeedback($messaggio);
            }
            catch (XClinicaException $ex) 
            {
                $messaggio = "Clinica inesistente"; // Se la clinica non esiste
                $vPrenotazione->visualizzaFeedback($messaggio);
            }
        }                    
        else
        {
            $messaggio = "C'è stato un errore. Non è stato trovato l'id della prenotazione";
            $vPrenotazione->visualizzaFeedback($messaggio);
        }
    }
    
}

