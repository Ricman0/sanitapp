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
                            $this->visualizzaRefertiClinica($username, $tipoUser, $vReferti);
                            break;
                        case 'medico':
                            $eMedico = new EMedico(null, $username);
                            $risultato = $eMedico->cercaReferti();
                            if (!is_bool($risultato)) {
                                $vReferti->restituisciPaginaRisultatoReferti($risultato, $tipoUser);
                            } else {
                                $vReferti->visualizzaFeedback( "errore in CReferti VisualizzaReferti in clinica. ");
                            }
                            break;

                        case 'utente':
                            $eUtente = new EUtente(NULL, $username);
                            $referti = $eUtente->cercaReferti();
                            if(is_array($referti) && count($referti)>0)
                            {
                               $vReferti->restituisciPaginaRisultatoReferti($referti, $tipoUser); 
                            }
                            else
                            {
                                $vReferti->visualizzaFeedback('Non sono presenti referti.');
                            }
                            
                            
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

    public function visualizzaRefertiClinica($username, $tipoUser, $vReferti) {
        $idPrenotazioneReferto = $vReferti->recuperaValore('id');
        if ($idPrenotazioneReferto === FALSE) {    //visualizzo tutti i referti
            $eClinica = new EClinica($username);
            $referti = $eClinica->cercaReferti();
            if (!is_bool($referti)) {  //ci sono referti da visualizzare
//                print_r($referti);
                $vReferti->restituisciPaginaRisultatoReferti($referti, $tipoUser);
            } else {
                 $vReferti->visualizzaFeedback("errore in CReferti VisualizzaReferti in clinica");
            }
        } else {    //visualizzo le info di un solo referto
            $eReferto = new EReferto($idPrenotazioneReferto);
            $ePrenotazione = new EPrenotazione($idPrenotazioneReferto);
            $eEsame = new EEsame($ePrenotazione->getIdEsamePrenotazione());
            $eClinica = new EClinica(NULL, $eEsame->getPartitaIVAClinicaEsame());
            $eUtente = new EUtente($ePrenotazione->getUtenteEffettuaEsamePrenotazione());
            $vReferti->visualizzaInfoReferto($eReferto, $ePrenotazione, $eEsame, $eUtente, $eClinica, $tipoUser);
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

}
