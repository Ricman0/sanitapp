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
        $this->_attributiTabella = "IDPrenotazione, IDEsame, PartitaIVAclinica, " 
                . "Tipo, Confermata, Eseguita, CodFiscaleUtenteEffettuaEsame, " 
                . "CodFiscaleMedicoPrenotaEsame, CodFiscaleUtentePrenotaEsame, "
                . "DataEOra";
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
    public function cercaPrenotazioni($codiceFiscaleUtente, $idPrenotazione=NULL)
    {
        if($idPrenotazione!==NULL && $idPrenotazione!==FALSE)//posso togliere questa seconda condizione ma metto != FALSE poichè magari recuperaValore('id') può non contenere l'id e per qualche motivo c'è un errore
        {
            // si vuole visualizzare una prenotazione dell'utente
            $query =  "SELECT IDPrenotazione, esame.NomeEsame, clinica.NomeClinica, "
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
            $query =  "SELECT IDPrenotazione, esame.NomeEsame, clinica.NomeClinica, "
                . "DataEOra, Eseguita, esame.MedicoEsame "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.PartitaIVAClinica=clinica.PartitaIVA) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscaleUtente . "')) ";
        }
//        echo $query; // per il debug, da eliminare
        $risultato = $this->eseguiQuery($query);
//        print_r($risultato); // per il debug, da eliminare
        return $risultato;
    }
    
    /**
     * Permette di ottenere tutte le prenotazioni che un medico ha effettuato
     * @param string $cf il codice fiscale del medico di cui vogliamo conoscere le prenotazioni
     * @return array|boolean
     */
    public function cercaPrenotazioniMedico($cf) {
        $query =   "SELECT IDPrenotazione, prenotazione.IDEsame, clinica.NomeClinica, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DataEOra, utente.CodFiscale "
                . "FROM prenotazione, esame, utente, clinica "
                . "WHERE ((prenotazione.PartitaIVAClinica=clinica.PartitaIVA) AND (prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(prenotazione.CodFiscaleMedicoPrenotaEsame='" . $cf . "')) ";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    /**
     * Metodo che consente di visualizzare tutte le prenotazioni di una clinica
     * 
     * @access public
     * @param string $partitaIVAClinica La partita IVA della clinica di cui si vogliono trovare tutte le prenotazioni
     * @return Array Le prenotazioni
     */
    public function cercaPrenotazioniClinica($partitaIVAClinica)
    {
        //si vogliono visualizzare tutte le prenotazioni di una clinica
        $query =   "SELECT IDPrenotazione, prenotazione.IDEsame, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DataEOra, utente.CodFiscale "
                . "FROM prenotazione, esame, utente "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(prenotazione.PartitaIVAClinica='" . $partitaIVAClinica . "')) ";
        return $this->eseguiQuery($query);
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
    
    public function cercaPrenotazioniEsameClinicaData($idEsame, $partitaIVA, $data) 
    {
        //da stringa a data
        $data = strtotime($data);
        //cambio il formato della data per poterlo confrontare con quella nel db
        $data = date("Y-m-d", $data);
//        echo($data);
        $query =  "SELECT prenotazione.* "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame='" . $idEsame . "') AND "
                . "(prenotazione.PartitaIVAClinica='" . $partitaIVA . "') AND "
                . "(DATE(DataEOra)='" . $data . "'))";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    public function aggiungiPrenotazione($ePrenotazione) 
    {
        $valoriAttributi = $ePrenotazione->getValoriAttributi();
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO " . $this->_nomeTabella . " (" . $this->_attributiTabella . ") VALUES(" . $valoriAttributi . ")";
        // eseguo la query
//        $query = "INSERT INTO prenotazione ()"
        return  $this->eseguiQuery($query);
    }
    
    public function cercaPrenotazioneById($id) {
        
        $query = "SELECT * "
                . "FROM prenotazione "
                . "WHERE IdPrenotazione = '" . $id . "'";
        return $this->eseguiQuery($query);
        
        
    }
    
    /**
     * Metodo che consente di confermare una prenotazione 
     * 
     * @access public
     * @param string $idPrenotazione L'id della prenotazione
     * @return boolean TRUE se la conferma è avvenuta con successo
     */
    public function confermaPrenotazione($idPrenotazione) 
    {
        $query = "UPDATE " . $this->_nomeTabella . " SET Confermata=TRUE WHERE IDPrenotazione='" . $idPrenotazione . "'";
        return $this->eseguiQuery($query);
    }
    
//    public function getAttributi($ePrenotazione) 
//    {
//        print_r($ePrenotazione);
//        
//        
       
//        foreach($ePrenotazione as $attributo => $valore) 
//        {
//            echo " $attributo ". " $valore ";
//            $valoriAttributi = $valoriAttributi . $valore . "', '" ;
//        }
//        $c = (strlen($valoriAttributi))-3;
//        print_r($c);
//        $valoriAttributi = substr($valoriAttributi, 0, $c);
//        print_r($valoriAttributi);
//    }
}
