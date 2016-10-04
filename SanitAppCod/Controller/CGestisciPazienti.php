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
    public function visualizzaPazienti() 
    {
        $sessione = USingleton::getInstance('USession');
        $usernameMedico = $sessione->leggiVariabileSessione('usernameLogIn');
        $vPazienti = USingleton::getInstance('VGestisciPazienti');
        $cf = $vPazienti->getId();
        if ($cf === FALSE)
        {
            // vogliamo visualizzare tutti i pazienti del medico
            $medico =USingleton::getInstance('FMedico');
            $risultato = $medico->cercaPazienti($usernameMedico);
             
        }
    }
}
