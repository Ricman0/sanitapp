<?php

/**
 * Classe che consente di inviare e ricevere dati JSON
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */

class VJSON {
    
    /**
     * Metodo che consente di inviare dati in formato JSON.
     * 
     * @access public
     * @param mixed $dati Dati da condificare in JSON e poi visualizzarli
     */
    public function inviaDatiJSON($dati) 
    {
        // stampa i dati codificati in formato JSON
        echo json_encode($dati);
    }
    
    /**
     * Metodo che consente di prelevare dati in formato JSON e decodificarli in un oggetto PHP.
     * 
     * @access public
     * @param string $dati Dati JSON da decondificare 
     * @return object Oggetto PHP contenente i dati decodificati
     */
    public function getDatiJSON($dati) 
    {
        return  json_decode($dati);
    }
}
