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
                    case 'Clinica':
                        $eClinica = new EClinica($username);
                        $partitaIVAClinica = $eClinica->getPartitaIVAClinica();
                        $fReferti = USingleton::getInstance('FReferto');
                        $risultato = $fReferti->cercaRefertiClinica($partitaIVAClinica);
                        if(!is_bool($risultato))
                        {
                            print_r($risultato);
                            $vReferti->restituisciPaginaRisultatoRefertiClinica($risultato);
                        }
                        else
                        {
                            echo "errore in CReferti VisualizzaReferti in clinica";
                        }



                        break;

                    default:
                        break;
                }


                break;

            default:
                break;
        }
    }
}
