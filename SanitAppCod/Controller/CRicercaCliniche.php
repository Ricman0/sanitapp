<?php


/**
 * Description of CCliniche
 * 
 * La classe CCliniche si occupa di gestire il caso d'uso della ricerca delle
 * cliniche nell'applicazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaCliniche {
    
    /**
     * Metodo che permette di impostare la pagina per poter effettuare la 
     * ricerca di una o più cliniche presenti nell'aplicazione
     * 
     * @access public
     */
    public function impostaPaginaRicercaCliniche()
    {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        $vCliniche->restituisciFormRicercaCliniche();
    }
}
