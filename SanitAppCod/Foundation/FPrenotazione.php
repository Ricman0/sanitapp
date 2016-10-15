<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FPrenotazione
 *
 * @package Foundation
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FPrenotazione extends FDatabase{
    
    /**
     * Costruttore della classe FPrenotazione
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "prenotazione";
        // imposto gli attributiTabella
        $this->_attributiTabella = "IDPrenotazione, " + "IDEsame, " + "PartitaIVAclinica, " +
                + "Tipo, " + "Confermata, " + "Eseguita, "+ "CodFiscaleUtenteEffettuaEsame, " 
                + "CodFiscaleMedicoPrenotaEsame, "+ "CodFiscaleUtentePrenotaEsame, "
                + "DataEOra";
    }
    
    /**
     * Metodo che permette la ricerca di tutte le prenotazioni di un utente
     * 
     * @access public
     * @param string $codiceFiscaleUtente Codice fiscale dell'utente di cui si vuole
     * cercare tutte le prenotazioni
     * @return boolean|array Il risultato della query
     * 
     */
    public function cercaPrenotazioni($codiceFiscaleUtente, $idPrenotazione)
    {
        if($idPrenotazione!==FALSE)
        {
            // si vuole visualizzare una prenotazione dell'utente
            $query =  "SELECT IDPrenotazione, esame.Nome, clinica.NomeClinica, "
                . "DataEOra, Eseguita, esame.MedicoEsame "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.PartitaIVAClinica=clinica.PartitaIVA) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscaleUtente . "') "
                . "AND (IDPrenotazione='" . $idPrenotazione . "')) ";
        }
        else
        {
            // solo il codice fiscale quindi si vogliono visualizzare tutte le 
            //prenotazioni di un utente
            $query =  "SELECT IDPrenotazione, esame.Nome, clinica.NomeClinica, "
                . "DataEOra, Eseguita, esame.MedicoEsame "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.PartitaIVAClinica=clinica.PartitaIVA) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscaleUtente . "')) ";
        }
                        
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    public function cercaPrenotazioniEsameClinica($idEsame, $partitaIVA) 
    {
        $query =  "SELECT prenotazione.* "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.PartitaIVAClinica=clinica.PartitaIVA)) ";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
}
