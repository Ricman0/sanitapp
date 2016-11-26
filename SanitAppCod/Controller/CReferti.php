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
                if($ePrenotazione->getEseguitaPrenotazione()){
                    $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                    $partitaIva = $ePrenotazione->getPartitaIVAPrenotazione();
                    $eEsame = new EEsame($idEsame);
                    $medicoEsame = $eEsame->getMedicoEsame();
                    $vReferti->restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame);
                }
                break;
            
            case 'download':
                
                $idPrenotazione = $vReferti->recuperaValore('id');
                $eReferto = new EReferto($idPrenotazione);
                if (file_exists($eReferto->getContenutoReferto())) {
                    header("Cache-Control: public");
                    header("Content-type:application/pdf");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename= " . $eReferto->getContenutoReferto());
                    header("Content-Transfer-Encoding: binary");
                    readfile($eReferto->getContenutoReferto());
                } else {
                    throw new XFileException('Attenzione, problema imprevisto, il file non esiste. ');
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
                try
                {
                    $this->uploadReferto();
                } 
                catch (XDatiRefertoException $e) {
                    print_r( $e->getMessage());
                    $vReferti->visualizzaFeedback($messaggio);
                    

                }
                

                break;

            default:
                break;
        }
    }

    public function uploadReferto() {
        $vReferti = USingleton::getInstance('VReferti');
        $uValidazione = USingleton::getInstance('UValidazione');
        $infoFile = $vReferti->recuperaInfoFile('referto');
        if ($uValidazione->validaDatiReferto($infoFile)){
            $datiReferto = $vReferti->recuperaDatiReferto();
            print_r($datiReferto);
            $eReferto = new EReferto($datiReferto['idPrenotazione'], $datiReferto['partitaIVA'], $datiReferto['idEsame'], $datiReferto['medicoEsame'], $infoFile['fileName']);
            $eReferto->spostaReferto($infoFile['tmpName']);
            if ($eReferto->inserisciReferto()) 
            {
                $vReferti->refertoAggiunto();
            }
        }
        else
            {
            throw new XDatiRefertoException($uValidazione->getDatiErrati());
        }
    }

}
