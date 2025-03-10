<?php

/**
 * La classe CReferti si occupa della gestione dei referti.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CReferti {

    /**
     * Metodo che consente di gestire le richieste GET per il controller 'referti'.
     * 
     * @access public
     */
    public function gestisciReferti() {

        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $vReferti = USingleton::getInstance('VReferti');
        $idPrenotazione = $vReferti->recuperaValore('id');
        $task = $vReferti->getTask();
        switch ($task) {

            case 'aggiungi':
                $this->aggiuntaReferto($idPrenotazione);
                break;

            case 'download':
                $eReferto = new EReferto($idPrenotazione);
                $vReferti->downloadReferto($eReferto->getFileNameReferto(), $eReferto->getContenutoReferto());
                break;

            case 'visualizza': // GET referti/visualizza
                $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
                    switch ($tipoUser) {
                        case 'clinica':
                            $this->visualizzaRefertiClinica($username);
                            break;
                        case 'medico':
                            $this->tryVisualizzaRefertiMedico($username);
                            break;
                        case 'utente':
                            $this->tryVisualizzaRefertiUtente($username);
                            break;
                        default:
                            break;
                    }
                break;
            default:
                break;
        }
    }

    /**
     * Metodo che consente di gestire le richieste POST per il controller 'referto'.
     * 
     * @access public
     */
    public function gestisciRefertiPOST() {

        $vReferti = USingleton::getInstance('VReferti');
        $task = $vReferti->getTask();
        switch ($task) {
            case 'elimina':
                try {
                    $idPrenotazione = $vReferti->recuperaValore('id');
                    $eReferto = new EReferto($idPrenotazione);
                    $eReferto->eliminaReferto();
                    $vReferti->visualizzaFeedback('Referto eliminato con successo.');
                } catch (XRefertoException $ex) {
                    $vReferti->visualizzaFeedback('Referto Inesistente. Non è stato possibile eliminare il referto.');
                }
                catch (XDBException $ex) {
                    $vReferti->visualizzaFeedback("C'è stato un errore. Non è stato possibile eliminare il referto.");
                }
                break;
            
            case 'upload':
                try {
                    $this->uploadReferto();
                } catch (XDatiRefertoException $ex) {
                    $vReferti->visualizzaFeedback('Problema upload. ');
                } catch (XRefertoException $ex) {
                    $vReferti->visualizzaFeedback("Referto inesistente. Non è stato possibile recuperare il referto");
                } catch (XDBException $ex) {
                    $vReferti->visualizzaFeedback("Errore durante l'inserimento dei referti");
                }
                catch (XPrenotazioneException $ex) {
                    $vReferti->visualizzaFeedback("Prenotazione inesistente. Referto inserito ma non è stato possibile rinviare la mail di notifica. Contatti l'amministratore per risolvere il problema.");
                }
                catch (XEsameException $ex) {
                    $vReferti->visualizzaFeedback("Esame inesistente. Referto inserito ma non è stato possibile rinviare la mail di notifica. Contatti l'amministratore per risolvere il problema.");
                }
                catch (XUtenteException $ex) {
                    $vReferti->visualizzaFeedback("Utente inesistente. Referto inserito ma non è stato possibile rinviare la mail di notifica. Contatti l'amministratore per risolvere il problema.");
                }
                break;
            
            case 'condividi':
                $sessione = USingleton::getInstance('USession');
                $username = $sessione->leggiVariabileSessione('usernameLogIn');
                $condividiConMedico = $vReferti->recuperaValore('condividiConMedico');
                $vJSON = USingleton::getInstance('VJSON');
                $idPrenotazione = $vReferti->recuperaValore('id');
                try {
                    $eReferto = new EReferto($idPrenotazione);
                    $eUtente = new EUtente(NULL, $username);
                    if($condividiConMedico !== FALSE)
                    {
                        // utente vuole condividere il referto con il medico curante
                        if($eUtente->getCodFiscaleMedicoUtente() !== NULL && $condividiConMedico==='true')//  se l'utente ha impostato il medico curante
                        {
                            $condiviso = $eReferto->condividi(NULL, $eUtente->getCodFiscaleMedicoUtente(), TRUE);
                            if($condiviso === TRUE)
                            {
                                
                                $vJSON->inviaDatiJSON('OK');
                            }
                            else
                            {
                               
                                $vJSON->inviaDatiJSON('NO');
                            }
                        }
                        else
                        {
                            // non è possibile condividere con il medico in quanto non è impostato alcun medico curante
                            //  oppure non si vuole più condiviere il referto con il medico
                            $condiviso = $eReferto->condividi(NULL, $eUtente->getCodFiscaleMedicoUtente(), FALSE);
                            if($condiviso === TRUE)
                            {
                                $vJSON->inviaDatiJSON('NO'); // non codiviso con medico
                            }
                        }
                    }
                    else // vuoi condividerla con un utente
                    {
                        
                    }
                } catch (XRefertoException $ex) {
                    $vJSON->inviaDatiJSON('null');
                }
                catch (XUtenteException $ex) {
                    $vJSON->inviaDatiJSON('null');
                }
                catch (XDBException $ex) {
                    $vJSON->inviaDatiJSON('null');
                }
                
                
                break;
            default:
                break;
        }
    }

    /**
     * Metodo che richiama la pagina di upload del referto.
     * 
     * @access private
     * @param string $idPrenotazione id della prenotazione a cui associare il referto
     */
    private function aggiuntaReferto($idPrenotazione) {
        $vReferti = USingleton::getInstance('VReferti');
        $ePrenotazione = new EPrenotazione($idPrenotazione);
        if ($ePrenotazione->getEseguitaPrenotazione()) {
            $idEsame = $ePrenotazione->getIDEsamePrenotazione();
            $eEsame = new EEsame($idEsame);
            $partitaIva = $eEsame->getPartitaIVAClinicaEsame();
            $medicoEsame = $eEsame->getMedicoEsameEsame();
            $vReferti->restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame);
        } else {
            $vReferti->visualizzaFeedback('Impossibile aggiungere il referto, esame non eseguito');
        }
    }

    /**
     * Metodo che consente l'upload del referto.
     * 
     * @access private
     */
    private function uploadReferto() {
        $vReferti = USingleton::getInstance('VReferti');
        $uValidazione = USingleton::getInstance('UValidazione');
        $infoFile = $vReferti->recuperaInfoFile('referto');
        if ($uValidazione->validaDatiReferto($infoFile)) {
            $datiReferto = $vReferti->recuperaDatiReferto();
            $file = $vReferti->recuperaFile('referto');
            $eReferto = new EReferto($datiReferto['idPrenotazione'], $datiReferto['medicoEsame'], $file, $infoFile['fileName']);
            if ($eReferto->inserisciReferto()) {
                $ePrenotazione = new EPrenotazione($datiReferto['idPrenotazione']);
                $eEsame = new EEsame($datiReferto['idEsame']);
                $eUtente = new EUtente($ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione());
                $datiNotifica['nomeUtente'] = $eUtente->getNomeUtente();
                $datiNotifica['cognomeUtente'] = $eUtente->getCognomeUtente();
                $datiNotifica['email'] = $eUtente->getEmailUser();
                $dataEOra = $ePrenotazione->getDataEOraPrenotazione();
                $data = strtotime(substr($dataEOra, 0, 10));
                $datiNotifica['data'] = date('d-m-Y', $data);
                $datiNotifica['ora'] = substr($dataEOra, 11,5);
                $datiNotifica['nomeEsame'] = $eEsame->getNomeEsameEsame();
                $mail = USingleton::getInstance('UMail');
                $messaggio = 'Il referto è stato aggiunto correttamente. ';
                if($mail->inviaNotificaReferto($datiNotifica)===TRUE)
                {
                   $messaggio = $messaggio . " É stata inviata una mail di notifica all'utente. "; 
                }
                else
                {
                    $messaggio = $messaggio . "  Non è stata possibile inviare una mail di notifica all'utente. Contattare l'amministratore. "; 
                }
                $vReferti->visualizzaFeedback($messaggio);
            }
        } else {
            $vReferti->visualizzaFeedback($uValidazione->getDatiErrati());
        }
    }

    /**
     * Metodo che consente di visualizzare tutti i referti di un utente.
     * 
     * @access private
     * @param string $username L'username dell'utente di cui si vogliono visualizzare i referti
     */
    private function tryVisualizzaRefertiUtente($username) {
        $vReferti = USingleton::getInstance('VReferti');
        $idPrenotazioneReferto = $vReferti->recuperaValore('id');
        if ($idPrenotazioneReferto === FALSE) 
        {// visualizzo tutti i referti dell'utente
            try {
                $eUtente = new EUtente(NULL, $username);
                $referti = $eUtente->cercaReferti();
                if(is_array($referti) && count($referti)>0)
                {
                   $vReferti->restituisciPaginaRisultatoReferti($referti, 'utente'); 
                }
                else
                {
                    $vReferti->visualizzaFeedback('Non sono presenti referti.');
                }
            } catch (XUtenteException $ex) {
                $vReferti->visualizzaFeedback("Utente inesistente. Non è stato possibile recuperare le informazioni del referto");
            } catch (XDBException $ex) {
                $vReferti->visualizzaFeedback("Non è stato possibile recuperare le informazioni del referto");
            }
        }
        else
        {// visualizzo un referto dell'utente
            try {
                $eReferto = new EReferto($idPrenotazioneReferto);
                $ePrenotazione = new EPrenotazione($idPrenotazioneReferto);
                $eEsame = new EEsame($ePrenotazione->getIDEsamePrenotazione());
                $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                $eUtente = new EUtente($ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione());
                $vReferti->visualizzaInfoReferto($eReferto, $ePrenotazione, $eEsame, $eUtente, $eClinica, 'utente');
            } 
            catch (XRefertoException $ex) {
                $vReferti->visualizzaFeedback("Referto inesistente. Non è stato possibile recuperare il referto");
            }
            catch (XPrenotazioneException $ex) {
                $vReferti->visualizzaFeedback("Prenotazione inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
            catch (XEsameException $ex) {
                $vReferti->visualizzaFeedback("Esame inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
            catch (XClinicaException $ex) {
                $vReferti->visualizzaFeedback("Clinica inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
            catch (XUtenteException $ex) {
                $vReferti->visualizzaFeedback("Utente inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
        }
    }
    
    
    /**
     * Metodo che consente ad un medico di visualizzare tutti i referti dei propri pazienti.
     * 
     * @access public
     * @param string $username L'username dell'utente di cui si vogliono visualizzare i referti
     */
    public function tryVisualizzaRefertiMedico($username) {
        $vReferti = USingleton::getInstance('VReferti');
        $idPrenotazioneReferto = $vReferti->recuperaValore('id');
        if ($idPrenotazioneReferto === FALSE)
        {
            try 
            {
                $eMedico = new EMedico(null, $username);
                $referti = $eMedico->cercaReferti();
                if(is_array($referti) && count($referti)>0)
                {
                   $vReferti->restituisciPaginaRisultatoReferti($referti, 'medico'); 
                }
                else
                {
                    $vReferti->visualizzaFeedback('Non sono presenti referti.');
                }
            } 
            catch (XMedicoException $ex) {
                $vReferti->visualizzaFeedback('Medico inestistente. Non è stato possibile recuperare i referti.');
            }
            catch (XDBException $ex) {
                $vReferti->visualizzaFeedback("C'è stato un errore. Non è stato possibile recuperare i referti.");
            } 
        }
        else 
        {
            try {
                $eReferto = new EReferto($idPrenotazioneReferto);
                $ePrenotazione = new EPrenotazione($idPrenotazioneReferto);
                $eEsame = new EEsame($ePrenotazione->getIDEsamePrenotazione());
                $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                $eUtente = new EUtente($ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione());
                $vReferti->visualizzaInfoReferto($eReferto, $ePrenotazione, $eEsame, $eUtente, $eClinica, 'medico');
            } 
            catch (XRefertoException $ex) {
                $vReferti->visualizzaFeedback("Referto inesistente. Non è stato possibile recuperare il referto");
            }
            catch (XPrenotazioneException $ex) {
                $vReferti->visualizzaFeedback("Prenotazione inesistente. Non è stato possibile recuperare le informazioni del referto.");
            }
            catch (XEsameException $ex) {
                $vReferti->visualizzaFeedback("Esame inesistente. Non è stato possibile recuperare le informazioni del referto.");
            }
            catch (XClinicaException $ex) {
                $vReferti->visualizzaFeedback("Clinica inesistente. Non è stato possibile recuperare le informazioni del referto.");
            }
            catch (XUtenteException $ex) {
                $vReferti->visualizzaFeedback("Utente inesistente. Non è stato possibile recuperare le informazioni del referto.");
            }
        }
    }

    /**
     * Metodo che consente ad una clinica di visualizzare tutti i referti dei propri clienti gestendo le eventuali eccezioni.
     * 
     * @access private
     * @param string $username L'username della clinica di cui si vogliono visualizzare i referti
     */
    private function tryVisualizzaRefertiClinica($username) {
        $vReferti = USingleton::getInstance('VReferti');
        try {
                $eClinica = new EClinica($username);
                $referti = $eClinica->cercaReferti();
                if (is_array($referti) && count($referti)>0) {  //ci sono referti da visualizzare
                    $vReferti->restituisciPaginaRisultatoReferti($referti, 'clinica');
                } 
                else 
                {
                    $vReferti->visualizzaFeedback("Non sono ancora stati caricati referti");
                }
            } 
            catch (XClinicaException $ex) {
                $vReferti->visualizzaFeedback("Errore durante il recupero dei referti");
            }
            catch (XDBException $ex) {
                $vReferti->visualizzaFeedback("Errore durante il recupero dei referti");
            }
    }
    
    /**
     * Metodo che consente di visualizzare tutte le informazioni di un referto.
     * 
     * @access private
     * @param string $idPrenotazioneReferto L'id del referto di cui si vogliono visualizzare tutte le informazioni
     */
    private function tryVisualizzaRefertoClinica($idPrenotazioneReferto) {
        $vReferti = USingleton::getInstance('VReferti');
        try {
                $eReferto = new EReferto($idPrenotazioneReferto);
                $ePrenotazione = new EPrenotazione($idPrenotazioneReferto);
                $eEsame = new EEsame($ePrenotazione->getIDEsamePrenotazione());
                $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                $eUtente = new EUtente($ePrenotazione->getCodFiscaleUtenteEffettuaEsamePrenotazione());
                $vReferti->visualizzaInfoReferto($eReferto, $ePrenotazione, $eEsame, $eUtente, $eClinica, 'clinica');
            } 
            catch (XRefertoException $ex) {
                $vReferti->visualizzaFeedback("Referto inesistente. Non è stato possibile recuperare il referto");
            }
            catch (XPrenotazioneException $ex) {
                $vReferti->visualizzaFeedback("Prenotazione inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
            catch (XEsameException $ex) {
                $vReferti->visualizzaFeedback("Esame inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
            catch (XClinicaException $ex) {
                $vReferti->visualizzaFeedback("Clinica inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
            catch (XUtenteException $ex) {
                $vReferti->visualizzaFeedback("Utente inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
    }
    
    /**
     * Metodo che consente gi gestire le richieste GET del controller 'referti'  e task 'visualizza'.
     * Permette di visualizzare tutti i referti o un solo referto a seconda del valore dell'id della richiesta GET.
     * 
     * @access private
     * @param string $username L'username della clinica di cui si vogliono visualizzare i referti
     */
    private function visualizzaRefertiClinica($username) {
        $vReferti = USingleton::getInstance('VReferti');
        $idPrenotazioneReferto = $vReferti->recuperaValore('id');
        if ($idPrenotazioneReferto === FALSE) {    //visualizzo tutti i referti
            $this->tryVisualizzaRefertiClinica($username); 
        } 
        else { 
            //visualizzo le info di un solo referto
            $this->tryVisualizzaRefertoClinica($idPrenotazioneReferto);
        }
    }
}
