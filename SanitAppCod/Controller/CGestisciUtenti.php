<?php

/**
 * La classe CGestisciUtenti si occupa di bloccare automaticamente gli utenti che non hanno effettuato più di 3 prenotazioni.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciUtenti {
    
    /**
     * Metodo che consente di bloccare automaticamente gli utenti che non hanno effettuato più di 3 prenotazioni.
     * 
     * @access public
     */
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
