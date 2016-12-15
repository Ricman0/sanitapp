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
        $task = $vReferti->getTask();
        try {
            switch ($task) {

                case 'aggiungi':

                    $idPrenotazione = $vReferti->recuperaValore('id');
                    $ePrenotazione = new EPrenotazione($idPrenotazione);
                    if ($ePrenotazione->getEseguitaPrenotazione()) {
                        $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                        $partitaIva = $ePrenotazione->getPartitaIVAPrenotazione();
                        $eEsame = new EEsame($idEsame);
                        $medicoEsame = $eEsame->getMedicoEsame();
                        $vReferti->restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame);
                    }else{$vReferti->visualizzaFeedback('Impossibile aggiungere il referto, esame non eseguito');}
                    break;

                case 'download':

                    $idPrenotazione = $vReferti->recuperaValore('id');
                    $eReferto = new EReferto($idPrenotazione);
                    if ($eReferto->checkEsistenzaReferto()) {                       //eccezione XFileException
                        $vReferti->downloadReferto($eReferto->getContenutoReferto());
                    }

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
        } catch (XFileException $e) {
            $vReferti->visualizzaFeedback($e->getMessage());
        }
    }

    

    public function gestisciRefertiPOST() {

        $vReferti = USingleton::getInstance('VReferti');
        $task = $vReferti->getTask();
        switch ($task) {
            case 'upload':
                try {
                    $this->uploadReferto();
                } catch (XDatiRefertoException $e) {
                    $vReferti->visualizzaFeedback('Problema upload. ');
                }


                break;

            default:
                break;
        }
    }

    public function uploadReferto() {
        $vReferti = USingleton::getInstance('VReferti');
        $uValidazione = USingleton::getInstance('UValidazione');
        print_r($_FILES);
        $infoFile = $vReferti->recuperaInfoFile('referto');
        if ($uValidazione->validaDatiReferto($infoFile)) {
            $datiReferto = $vReferti->recuperaDatiReferto();
            $eReferto = new EReferto($datiReferto['idPrenotazione'], $datiReferto['partitaIVA'], $datiReferto['idEsame'], $datiReferto['medicoEsame'], $infoFile['fileName']);
            $eReferto->spostaReferto($infoFile['tmpName']);
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
     * @access public
     * @param string $username L'username dell'utente di cui si vogliono visualizzare i referti
     */
    public function tryVisualizzaRefertiUtente($username) 
    {
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
        } 
        catch (XUtenteException $ex) {
            $vReferti->visualizzaFeedback("Utente inesistente. Non è stato possibile recuperare le informazioni del referto");
        }
        catch (XDBException $ex) {
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
    
    
    private function visualizzaRefertiClinica($username) {
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
