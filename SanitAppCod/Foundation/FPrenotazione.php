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
     * @throws XDBException Se la query non è stata eseguita con successo
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
        return $this->eseguiQuery($query);
       
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
        print_r($query);
        // eseguo la query
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
    
    /**
     * Metodo che consente di eliminare la prenotazione passata per parametro
     * 
     * @access public
     * @param string $idPrenotazione L'id della prenotazione
     * @throws XDBException Se la query per eliminare la prenotazione specificata non è stata eseguita con successo
     * @return boolean TRUE se l'eliminazione è avvenuta con successo
     */
    public function eliminaPrenotazione($idPrenotazione) 
    {
        $query = 'DELETE FROM ' . $this->_nomeTabella .  " WHERE IDPrenotazione='" . $idPrenotazione . "'";
        return $this->eseguiQuery($query);
    }
    
    
    /**
     * Metodo che cerca se esistono prenotazioni per un determinato utente in una clinica specifica per un esame 
     * o se lo stesso utente ha già prenotazioni durante un determinato periodo.
     * 
     * @access public
     * @param string $cfUtente Il codice fiscale dell'utente che intende eseguire la prenotazione
     * @param string $idEsame L'id dell'esame di cui l'utente vuole effettuare la prenotazione
     * @param string $partitaIVA La partita IVA della clinica in cui intende prenotarsi l'utente
     * @param string $data La data della prenotazione(dd-mm-yyyy)
     * @param string $ora L'orario della prenotazione (mm:ss)
     * @param string $durata La durata della prenotazione(hh:mm:ss)
     * @throws XDBException Se c'è un errore durante l'esecuzione della query
     * @return Array Il risultato della query multipla. Ogni elemento dell'array è una prenotazione
     */
    public function cercaTraPrenotazioni($cfUtente, $idEsame, $partitaIVA, $data, $ora, $durata)
    {
        $ora = date( "H:i:s", strtotime( $ora ) ); // trasformo $ora  dal formato hh:mm nel formato hh:mm:ss
        $data = strtotime($data); // converto la stringa in un intero che indica la data in tempo
        $data = date('Y-m-d',$data); // converto la data in tempo in data secondo il formato per confrontarlo con la data del DB
        $durata = date_parse( $durata ); // rendo un array la stringa durata
        $ora2 = date( "H:i:s", strtotime( $ora . "+" . $durata['minute'] . " minutes" ) );//aggiungo minuti della durata
        $ora2 = date( "H:i:s", strtotime( $ora2 . "+" . $durata['hour'] . " hours" ) );// aggiungo le ora della durata
        /*
         * Con la prima query mi accerto che non ci siano prenotazioni 
         * in quel giorno per quell'esame per quell'utente in quella clinica.
         * Con la seconda query mi accerto che l'utente non abbia prenotazioni 
         * durante l'orario di svolgimento dell'esame che vuole andara a prenotare
         */
        $queryMultipla = "SELECT * "
                . "FROM prenotazione "
                . "WHERE (IDEsame='" . $idEsame . "' AND "
                . "PartitaIVAClinica='" . $partitaIVA . "' AND "
                . "CodFiscaleUtenteEffettuaEsame='" . $cfUtente . "' AND "
                . "DATE(DataEOra)='" . $data . "');"// fine prima query.  //DATE(DataEOra) prendo solo la data di un datetime
                . "SELECT * "
                . "FROM prenotazione "
                . "WHERE (CodFiscaleUtenteEffettuaEsame='" . $cfUtente . "' AND "
                . "DATE(DataEOra)='" . $data . "' AND "
                . "TIME(DataEOra) BETWEEN  '". $ora . "' AND '" . $ora2 . "')"; // cerco tra inizio della prenotazione e la fine della prenotazione;
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;                
    }
    
}
