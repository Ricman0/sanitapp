<?php

/**
 * La classe CRicercaCliniche si occupa di gestire il caso d'uso della ricerca delle
 * cliniche nell'applicazione.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaCliniche {
    
    /**
     * Metodo che permette di impostare la pagina per poter effettuare la 
     * ricerca di una o più cliniche presenti nell'applicazione.
     * 
     * @access public
     */
    public function impostaPaginaRicercaCliniche()                              //controllato
    {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        $vCliniche->restituisciFormRicercaCliniche();
    }
    

    /**
     * Metodo che consente di gestire le richieste GET per il controller 'cliniche'.
     * 
     * @access public
     */
    public function gestisciCliniche() {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        switch($vCliniche->getTask())
        { 
            case 'visualizza':
                $id = $vCliniche->recuperaValore('id');
                if(isset($id))
                {
                    
                    $eClinica = new EClinica(NULL, $id);
                    $vCliniche->visualizzaInfoClinicaOspite($eClinica);
                }
                break;
        }
    }
    
    /**
     * Metodo che consente di impostare la pagina dal risultato della ricerca delle cliniche.
     * 
     * @access public
     */
    public function impostaPaginaRisultatoCliniche()
    {
        $vCliniche = USingleton::getInstance('VRicercaCliniche');
        $fCliniche = USingleton::getInstance('FClinica');
        $risultato = $fCliniche->cercaClinica($vCliniche->recuperaValore('nome'), $vCliniche->recuperaValore('luogo'));       
        if(is_array($risultato) && count($risultato)>0)
        {
            $vCliniche->restituisciPaginaRisultatoCliniche($risultato);
        }
        else
        {
            $messaggio="La ricerca non prodotto alcun risultato.";
            $vCliniche->visualizzaFeedback($messaggio, TRUE);
        }  
    }
}
