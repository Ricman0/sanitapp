<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestisciUtenti
 *
 * @author Claudia
 */
class CGestisciUtenti {
    
    public function cercaUtentiDaBloccare() {
        // manca il passaggio attraverso l'entity
        $fUtenti = USingleton::getInstance('FUtente');
        $utentiApp = $fUtenti->getUtentiNonBloccati();
        foreach ($utentiApp as $utente) 
        {
            $codiceFiscaleUtenteDaControllare = $utente['CodFiscale'];
            $dataOdierna = date("Y-m-d");
            $eUtente = new EUtente($codiceFiscaleUtenteDaControllare);
            $eUtente->controllaSeBloccare($dataOdierna);
        }
    }
}
