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
                        $eClinica = new EClinica($username);
                        $partitaIVAClinica = $eClinica->getPartitaIVAClinica();
                        $fReferti = USingleton::getInstance('FReferto');
                        $referti = $fReferti->cercaRefertiClinica($partitaIVAClinica);
                        if(!is_bool($referti))
                        {
                            print_r($referti);
                            $vReferti->restituisciPaginaRisultatoReferti($referti,$tipoUser);
                        }
                        else
                        {
                            echo "errore in CReferti VisualizzaReferti in clinica";
                        }
                        break;
                    case 'medico':
                        $eMedico = new EMedico(null, $username);
                        $cfMedico = $eMedico->getCodiceFiscaleMedico();
                        $fReferti = USingleton::getInstance('FReferto');
                        $risultato = $fReferti->cercaRefertiPazientiMedico($cfMedico);
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
        $idPrenotazione = $vReferti->recuperaValore('idPrenotazione');
        $idEsame = $vReferti->recuperaValore('idEsame');
        $partitaIva = $vReferti->recuperaValore('partitaIva');
        $medicoEsame = $vReferti->recuperaValore('medicoEsame');
        $contenuto = $vReferti->recuperaFilePDF('referto');
        $eReferto = new EReferto($medicoEsame, $idPrenotazione, $partitaIva, $idEsame, $contenuto);
        $fReferto = USingleton::getInstance('FReferto');
        if($fReferto->inserisciReferto($eReferto))
        {
            $risultato['risultato'] = "SI";
        }
        echo json_encode($risultato);
        
        
    }
}
