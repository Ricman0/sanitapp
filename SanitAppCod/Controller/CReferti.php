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
        switch ($task) {
            
            case 'aggiungi':

                $idPrenotazione = $vReferti->recuperaValore('id');
                $ePrenotazione = new EPrenotazione($idPrenotazione);
                $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                $partitaIva = $ePrenotazione->getPartitaIVAPrenotazione();
                $eEsame = new EEsame($idEsame);
                $medicoEsame = $eEsame->getMedicoEsame();
                $vReferti->restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame);

                break;
            
            case 'download':
                
                $idPrenotazione = $vReferti->recuperaValore('id');
                
                $eReferto = new EReferto($idPrenotazione);
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename= " . $eReferto->getContenutoReferto());
                header("Content-Transfer-Encoding: binary");

                readfile($eReferto->getContenutoReferto());
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
                            print_r($risultato);
                            $vReferti->restituisciPaginaRisultatoReferti($risultato, $tipoUser);
                        } else {
                            echo "errore in CReferti VisualizzaReferti in clinica";
                        }
                        break;

                    case 'utente':
                        $eUtente = new EUtente(NULL, $username);
                        $referti = $eUtente->cercaReferti();
                        $vReferti->restituisciPaginaRisultatoReferti($referti, $tipoUser);
                        break;
                    default:
                        break;
                }
                break;

            

            default:
                break;
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
                echo "errore in CReferti VisualizzaReferti in clinica";
            }
        } else {    //visualizzo le info di un solo referto
            $eReferto = new EReferto($idPrenotazioneReferto);
            $ePrenotazione = new EPrenotazione($idPrenotazioneReferto);
            $eEsame = new EEsame($ePrenotazione->getIdEsamePrenotazione());
            $eClinica = new EClinica($eEsame->getPartitaIVAClinicaEsame());
            $eUtente = new EUtente($ePrenotazione->getUtenteEffettuaEsamePrenotazione());
            $vReferti->visualizzaInfoReferto($eReferto, $ePrenotazione, $eEsame, $eUtente, $eClinica, $tipoUser);
        }
    }

    public function gestisciRefertiPOST() {

        $vReferti = USingleton::getInstance('VReferti');
        $task = $vReferti->getTask();
        switch ($task) {
            case 'upload':
                
                $this->uploadReferto();

                break;

            default:
                break;
        }
    }

    public function uploadReferto() {
        $risultato['risultato'] = "NO";
        $vReferti = USingleton::getInstance('VReferti');
        $datiReferto = $vReferti->recuperaFile('referto');
        $eReferto = new EReferto($datiReferto['idPrenotazione'], $datiReferto['partitaIva'], $datiReferto['idEsame'], $datiReferto['medicoEsame'], $datiReferto['contenuto']);

        if ($eReferto->inserisciReferto()) {
            $risultato['risultato'] = "SI";
        }
        $vReferti = USingleton::getInstance('VReferti');
        echo json_encode($risultato);
    }

}
