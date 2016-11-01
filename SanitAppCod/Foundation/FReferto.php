<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FReferto
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FReferto extends FDatabase{
    
    /**
     * Costruttore della classe FReferto
     * 
     * @access public
     */
    public function __construct() {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "referto";
        $this->_attributiTabella = "IDReferto, IDPrenotazione, IDEsame, PartitaIVAClinica, " .
                "Contenuto, MedicoReferto, DataReferto";
    }
    
    /**
     * Permette di trovare tutti i referti dei clienti di una data clinica
     * @param string $partitaIVAClinica la partita iva della clinica
     */
    public function cercaRefertiClinica($partitaIVAClinica) 
    {
        
        $query =   "SELECT IDReferto, esame.IDEsame, prenotazione.IDPrenotazione, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DataReferto, prenotazione.CodFiscaleUtenteEffettuaEsame "
                . "FROM referto, prenotazione, esame, utente "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (referto.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(referto.PartitaIVAClinica='" . $partitaIVAClinica . "')) ";
        $risultato = $this->eseguiQuery($query);
        print_r($risultato);
        return $risultato;
        
    }
    
    /**
     * Permette di trovare tutti referti relativi ai pazienti di un dato medico
     * @param string $cfMedico codice fiscale del medico 
     */
    public function cercaRefertiPazientiMedico($cfMedico) 
    {
        
        $query =   "SELECT IDReferto, esame.IDEsame, prenotazione.IDPrenotazione, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DataReferto, prenotazione.CodFiscaleUtenteEffettuaEsame "
                . "FROM referto, prenotazione, esame, utente "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (referto.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(utente.CodFiscaleMedico='" . $cfMedico . "')) ";
        $risultato = $this->eseguiQuery($query);
        print_r($risultato);
        return $risultato;
        
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di una referto nel database
     * 
     * @access private
     * @param EReferto $referto il referto di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    private function getAttributi($referto) {        
        
        $valoriAttributi = "'" . $referto->getIDReferto() . "', '" 
                . $this->trimEscapeStringa($referto->getIDPrenotazione()) . "', '" 
                . $this->trimEscapeStringa($referto->getIDEsame()) . "', '" 
                . $this->trimEscapeStringa($referto->getPartitaIvaClinica()) . "', '" 
                . $referto->getContenutoReferto() . "', '"  
                . $this->trimEscapeStringa($referto->getMedicoReferto()) . "', '" 
                . $referto->getDataReferto() . "'"; 
                // manca la partita IVA della clinica;
        return $valoriAttributi;
    }
    
    /**
     *  Metodo per inserire nella tabella Referto una nuova riga ovvero
     * una nuovo referto
     * 
     * @param EReferto $referto l'entità referto da inserire nel db
     */
    public function inserisciReferto($referto) {
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($referto);

        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO ". $this->_nomeTabella ." ( ". $this->_attributiTabella .") VALUES( ". $valoriAttributi . ")";
        // eseguo la query
        return $this->eseguiQuery($query);
    }
}
