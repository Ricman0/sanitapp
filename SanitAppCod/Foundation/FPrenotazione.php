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
    public function cercaPrenotazioni($codiceFiscaleUtente)
    {
        $query =  "SELECT IDPrenotazione, prenotazione.IDEsame, esame.Nome, clinica.NomeClinica, "
                . "DataEOra, Confermata, Eseguita, Tipo, esame.MedicoEsame, "
                . "MATCH (prenotazione.CodFiscaleUtenteEffettuaEsame) AGAINST ('$codiceFiscaleUtente' IN BOOLEAN MODE), "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(esame.PartitaIVAClinica=prenotazione.PartitaIVAClinica) AND "
                . "(prenotazione.PartitaIVAClinica=clinica.PartitaIVA) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscaleUtente . "') AND "
                . "(MATCH (prenotazione.CodFiscaleUtenteEffettuaEsame) AGAINST ('$codiceFiscaleUtente' IN BOOLEAN MODE)))";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
}
