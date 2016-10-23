<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CRicerca
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicerca {
    /**
     * Metodo che
     * 
     * @access public
     */
    public function gestisciRicerca()
    {
        $vRicerca = USingleton::getInstance('VRicerca');
        $codiceFiscale = $vRicerca->getCodiceFiscale();
        $uValidazione = USingleton::getInstance('UValidazione');
        if($uValidazione->validaCodiceFiscale($codiceFiscale))
        {
            //il codice fiscale è valido
            // ora controllo che l'utente sia presente nel sistema
            $eUtente = new EUtente($codiceFiscale);
        }
    }
}
