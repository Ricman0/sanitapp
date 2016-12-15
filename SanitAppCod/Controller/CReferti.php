<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CReferti
 *
 * @author Claudia Di Marco & Riccardo Mantini 
 */
class CReferti {

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

            case 'visualizza':
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

    public function gestisciRefertiPOST() {

        $vReferti = USingleton::getInstance('VReferti');
        $task = $vReferti->getTask();
        switch ($task) {
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


                break;

            default:
                break;
        }
    }

    /**
     * Visualizza i referti in base al tipo di utente
     * @param string $tipoUser Tipo dell'utente
     * @param string $username Username dell'utente
     */
    private function visualizzaReferti($tipoUser, $username) {
        $vReferti = USingleton::getInstance('VReferti');
        switch ($tipoUser) {
            case 'clinica':
                $this->visualizzaRefertiClinica($username, $tipoUser);
                break;

            case 'medico':
                $eMedico = new EMedico(null, $username);
                $risultato = $eMedico->cercaReferti();
                if (!is_bool($risultato)) {
                    $vReferti->restituisciPaginaRisultatoReferti($risultato, $tipoUser);
                } else {
                    $vReferti->visualizzaFeedback("errore in CReferti VisualizzaReferti in clinica. ");
                }
                break;

            case 'utente':
                $this->tryVisualizzaRefertiUtente($username, $tipoUser);
                break;

            default:
                break;
        }
    }

    /**
     * Consente di visualizzare i referti di una clinica
     * @param string $username Lo username dell'utente
     * @param string $tipoUser Il tipo di utente
     */
    private function visualizzaRefertiClinica($username, $tipoUser) {
        $vReferti = USingleton::getInstance('VReferti');
        $idPrenotazioneReferto = $vReferti->recuperaValore('id');
        if ($idPrenotazioneReferto === FALSE) {    //visualizzo tutti i referti
            try {
                $eClinica = new EClinica($username);
                $referti = $eClinica->cercaReferti();
                if (is_array($referti) && count($referti) > 0) {  //ci sono referti da visualizzare
                    $vReferti->restituisciPaginaRisultatoReferti($referti, $tipoUser);
                } else {
                    $vReferti->visualizzaFeedback("Non sono ancora stati caricati referti");
                }
            } catch (XClinicaException $ex) {
                $vReferti->visualizzaFeedback("Errore durante il recupero dei referti");
            } catch (XDBException $ex) {
                $vReferti->visualizzaFeedback("Errore durante il recupero dei referti");
            }
        } else {    //visualizzo le info di un solo referto
            try {
                $eReferto = new EReferto($idPrenotazioneReferto);
                $ePrenotazione = new EPrenotazione($idPrenotazioneReferto);
                $eEsame = new EEsame($ePrenotazione->getIdEsamePrenotazione());
                $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                $eUtente = new EUtente($ePrenotazione->getUtenteEffettuaEsamePrenotazione());
                $vReferti->visualizzaInfoReferto($eReferto, $ePrenotazione, $eEsame, $eUtente, $eClinica, $tipoUser);
            } catch (XRefertoException $ex) {
                $vReferti->visualizzaFeedback("Referto inesistente. Non è stato possibile recuperare il referto");
            } catch (XPrenotazioneException $ex) {
                $vReferti->visualizzaFeedback("Prenotazione inesistente. Non è stato possibile recuperare le informazioni del referto");
            } catch (XEsameException $ex) {
                $vReferti->visualizzaFeedback("Esame inesistente. Non è stato possibile recuperare le informazioni del referto");
            } catch (XClinicaException $ex) {
                $vReferti->visualizzaFeedback("Clinica inesistente. Non è stato possibile recuperare le informazioni del referto");
            } catch (XUtenteException $ex) {
                $vReferti->visualizzaFeedback("Utente inesistente. Non è stato possibile recuperare le informazioni del referto");
            }
        }
    }


    /**
     * Richiama la pagina di upload del referto
     * @param VReferti $vReferti oggetto view 
     * @param string $idPrenotazione id della prenotazione a cui associare il referto
     */
    private function aggiuntaReferto($idPrenotazione) {
        $vReferti = USingleton::getInstance('VReferti');
        $ePrenotazione = new EPrenotazione($idPrenotazione);
        if ($ePrenotazione->getEseguitaPrenotazione()) {
            $idEsame = $ePrenotazione->getIdEsamePrenotazione();
            $partitaIva = $ePrenotazione->getPartitaIVAPrenotazione();
            $eEsame = new EEsame($idEsame);
            $medicoEsame = $eEsame->getMedicoEsame();
            $vReferti->restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame);
        } else {
            $vReferti->visualizzaFeedback('Impossibile aggiungere il referto, esame non eseguito');
        }
    }

    /**
     * Consente l'upload del referto
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
            $eReferto = new EReferto($datiReferto['idPrenotazione'], $datiReferto['partitaIVA'], $datiReferto['idEsame'], $datiReferto['medicoEsame'], $file, $infoFile['fileName']);
            if ($eReferto->inserisciReferto()) {
                $messaggio = 'Il referto è stato aggiunto correttamente. ';
                $vReferti->visualizzaFeedback($messaggio);
            }
        } else {
            $vReferti->visualizzaFeedback($uValidazione->getDatiErrati());
        }
    }

    /**
     * Metodo che consente di visualizzare tutti i referti di un utente
     * 
     * @access private
     * @param string $username L'username dell'utente di cui si vogliono visualizzare i referti
     */
    private function tryVisualizzaRefertiUtente($username, $tipoUser) {
        $vReferti = USingleton::getInstance('VReferti');
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
    
    /**
     * Metodo che consente ad un medico di visualizzare tutti i referti dei propri pazienti
     * 
     * @access public
     * @param string $username L'username dell'utente di cui si vogliono visualizzare i referti
     */
    public function tryVisualizzaRefertiMedico($username) {
        $vReferti = USingleton::getInstance('VReferti');
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
            $vReferti->visualizzaFeedback('Medico inestistente. Non è stato possibile recuperare i referti');
        }
        catch (XDBException $ex) {
            $vReferti->visualizzaFeedback("C'è stato un errore. Non è stato possibile recuperare i referti");
        }   
    }

    /**
     * Metodo che consente ad una clinica di visualizzare tutti i referti dei propri clienti
     * 
     * @access public
     * @param string $username L'username della clinica di cui si vogliono visualizzare i referti
     */
    public function tryVisualizzaRefertiClinica($username) {
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
    
    
    public function visualizzaRefertiClinica($username) {
        $vReferti = USingleton::getInstance('VReferti');
        $idPrenotazioneReferto = $vReferti->recuperaValore('id');
        if ($idPrenotazioneReferto === FALSE) {    //visualizzo tutti i referti
            $this->tryVisualizzaRefertiClinica($username); 
        } 
        else {    //visualizzo le info di un solo referto
            try {
                $eReferto = new EReferto($idPrenotazioneReferto);
                $ePrenotazione = new EPrenotazione($idPrenotazioneReferto);
                $eEsame = new EEsame($ePrenotazione->getIdEsamePrenotazione());
                $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
                $eUtente = new EUtente($ePrenotazione->getUtenteEffettuaEsamePrenotazione());
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
    }
}
