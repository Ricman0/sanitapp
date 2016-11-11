<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestisciPazienti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciPazienti {

    /**
     * Metodo che consente la visualizzazione di un paziente passato come parametro o tutti i pazienti
     * 
     * @access public
     */
    public function gestisciPazienti() {
        
        $vPazienti = USingleton::getInstance('VGestisciPazienti');
        $task = $vPazienti->getTask();
        switch ($task) {
            case 'visualizza':
                $this->visualizza();
                break;

            default:
                break;
        }
    }

    private function visualizza() 
    {
        $vPazienti = USingleton::getInstance('VGestisciPazienti');
        $sessione = USingleton::getInstance('USession');
        $usernameMedico = $sessione->leggiVariabileSessione('usernameLogIn');
        $cf = $vPazienti->recuperaValore('id');
        if ($cf === FALSE) {
            // vogliamo visualizzare tutti i pazienti del medico
            $eMedico = new EMedico(null, $usernameMedico);
            $risultato = $eMedico->cercaPazienti();
            if (is_array($risultato)) {
                $vPazienti->visualizzaPazienti($risultato);
            }
        } else {
            // si cerca un solo paziente
            $eUtente = new EUtente($cf);
            $vPazienti->visualizzaInfoUtente($eUtente);
        }
    }

}
