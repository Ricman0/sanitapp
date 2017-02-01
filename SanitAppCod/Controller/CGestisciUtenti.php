<?php

/**
 * Description of CGestisciUtenti
 *
 * @package Controller
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
