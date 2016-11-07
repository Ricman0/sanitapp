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
            case 'visualizza':
                $tipoUser = $sessione->leggiVariabileSessione('tipoUser');                
                switch ($tipoUser) {
                    case 'clinica':
                        $this->visualizzaRefertiClinica($username, $tipoUser, $vReferti);
                        break;
                    case 'medico':
                        $eMedico = new EMedico(null, $username);
                        $risultato = $eMedico->cercaReferti();
                        if(!is_bool($risultato))
                        {
                            print_r($risultato);
                            $vReferti->restituisciPaginaRisultatoReferti($risultato,$tipoUser);
                        }
                        else
                        {
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
                
                case 'aggiungi':
                
                    $idPrenotazione = $vReferti->getId();
                    $ePrenotazione = new EPrenotazione($idPrenotazione);
                    $idEsame = $ePrenotazione->getIdEsamePrenotazione();
                    $partitaIva = $ePrenotazione->getPartitaIVAPrenotazione();
                    $eEsame = new EEsame($idEsame);
                    $medicoEsame = $eEsame->getMedicoEsame();
                    $vReferti->restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame);
                
                break;

            default:
                break;
        }
    }
    
    public function visualizzaRefertiClinica($username, $tipoUser, $vReferti) {
        $idReferto = $vReferti->getId();
        if($idReferto === FALSE)
        {
            $eClinica = new EClinica($username);
            $referti = $eClinica->cercaReferti();
            if(!is_bool($referti))
            {
                print_r($referti);
                $vReferti->restituisciPaginaRisultatoReferti($referti,$tipoUser);
            }
            else
            {
                echo "errore in CReferti VisualizzaReferti in clinica";
            }

        }
        else
        {
            $eReferto = new EReferto($idReferto);
            $vReferti->visualizzaInfoReferto($eReferto, TRUE);
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
        $datiReferto = $vReferti->recuperaValoreReferto();
        $eReferto = new EReferto($datiReferto['idPrenotazione'], $datiReferto['partitaIva'],
                $datiReferto['idEsame'], $datiReferto['medicoEsame'],$datiReferto['contenuto']);
        
        if($eReferto->inserisciReferto())
        {
            $risultato['risultato'] = "SI";
        }
        $vReferti = USingleton::getInstance('VReferti');
        echo json_encode($risultato);
        
        
    }
}
