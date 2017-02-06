<?php

/**
 * La classe FPrenotazione si occupa della gestione della tabella 'prenotazione'.
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
        $this->_nomeColonnaPKTabella = "IDPrenotazione";
        // imposto gli attributiTabella
        $this->_attributiTabella = "IDPrenotazione, IDEsame, " 
                . "Tipo, Confermata, Eseguita, CodFiscaleUtenteEffettuaEsame, " 
                . "CodFiscaleMedicoPrenotaEsame, CodFiscaleUtentePrenotaEsame, "
                . "DataEOra";
    }
    
    /**
     * Metodo che permette la ricerca di tutte le prenotazioni di un utente.
     * 
     * @access public
     * @param string $codiceFiscaleUtente Codice fiscale dell'utente di cui si vuole
     * cercare tutte le prenotazioni
     * @return array Il risultato della query
     * @throws XDBException Se la query non è stata eseguita con successo
     * 
     */
    public function cercaPrenotazioni($codiceFiscaleUtente, $idPrenotazione=NULL)
    {
        if($idPrenotazione!==NULL && $idPrenotazione!==FALSE)//posso togliere questa seconda condizione ma metto != FALSE poichè magari recuperaValore('id') può non contenere l'id e per qualche motivo c'è un errore
        {
            // si vuole visualizzare una prenotazione dell'utente
            $query =  "SELECT IDPrenotazione, esame.NomeEsame, clinica.NomeClinica, "
                . "DATE_FORMAT(DataEOra,'%d-%m-%Y %H:%i') AS DataEOra, CASE WHEN prenotazione.Eseguita=0 THEN 'NO' ELSE 'SI' END AS Eseguita, esame.MedicoEsame "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(esame.PartitaIVAClinica=clinica.PartitaIVA) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscaleUtente . "') "
                . "AND (IDPrenotazione='" . $idPrenotazione . "')) LOCK IN SHARE MODE";
        }
        else
        {
            // solo il codice fiscale quindi si vogliono visualizzare tutte le 
            //prenotazioni di un utente
            $query =  "SELECT IDPrenotazione, esame.NomeEsame, clinica.NomeClinica, "
                . "DATE_FORMAT(DataEOra,'%d-%m-%Y %H:%i') AS DataEOra, CASE WHEN prenotazione.Eseguita=0 THEN 'NO' ELSE 'SI' END AS Eseguita, esame.MedicoEsame "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(esame.PartitaIVAClinica=clinica.PartitaIVA) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscaleUtente . "')) LOCK IN SHARE MODE";
        
            //CASE WHEN prenotazione.Eseguita=0 THEN 'NO' ELSE 'SI' END AS Eseguita
            // quando Eseguita=0 ovvero è false, rimpliazza lo zero con NO, altrimenti con SI
        }
        return $this->eseguiQuery($query);
    }
    
    /**
     * Permette di ottenere tutte le prenotazioni che un medico ha effettuato.
     * 
     * @param string $cf il codice fiscale del medico di cui vogliamo conoscere le prenotazioni da egli effettuate
     * @return array Il risultato della query
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaPrenotazioniMedico($cf) {
        $query =   "SELECT IDPrenotazione, prenotazione.IDEsame, clinica.NomeClinica, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DATE_FORMAT(DataEOra,'%d-%m-%Y %H:%i') AS DataEOra, utente.CodFiscale "
                . "FROM prenotazione, esame, utente, clinica "
                . "WHERE ((esame.PartitaIVAClinica=clinica.PartitaIVA) AND (prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(prenotazione.CodFiscaleMedicoPrenotaEsame='" . $cf . "'))  LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di visualizzare tutte le prenotazioni di una clinica.
     * 
     * @access public
     * @param string $partitaIVAClinica La partita IVA della clinica di cui si vogliono trovare tutte le prenotazioni
     * @return array Il risultato della query
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaPrenotazioniClinica($partitaIVAClinica)
    {
        //si vogliono visualizzare tutte le prenotazioni di una clinica
        $query =   "SELECT IDPrenotazione, prenotazione.IDEsame, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DATE_FORMAT(DataEOra,'%d-%m-%Y %H:%i') AS DataEOra, utente.CodFiscale "
                . "FROM prenotazione, esame, utente "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(esame.PartitaIVAClinica='" . $partitaIVAClinica . "')) LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    
    /**
     * Metodo che consente di cercare una prenotazione in una clinica.
     * 
     * @access public
     * @param string $idEsame L'id dell'esame
     * @param sting $partitaIVA  La partita IVA della clinica
     * @return array Il risultato della query
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaPrenotazioniEsameClinica($idEsame, $partitaIVA) 
    {
        $query =  "SELECT prenotazione.* "
                . "FROM prenotazione, esame, clinica "
                . "WHERE ((prenotazione.IDEsame=esame.IDEsame) AND "
                . "(esame.PartitaIVAClinica=clinica.PartitaIVA)) LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di cercare una prenotazione in una data in una clinica.
     * 
     * @access public
     * @param string $idEsame L'id dell'esame
     * @param sting $partitaIVA  La partita IVA della clinica
     * @param string $data La data della prenotazione in formato d-m-Y
     * @return array Il risultato della query
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaPrenotazioniEsameClinicaData($idEsame, $partitaIVA, $data) 
    {
        //da stringa a data
        $data = strtotime($data);
        //cambio il formato della data per poterlo confrontare con quella nel db
        $data = date("Y-m-d", $data);
        $query =  "SELECT prenotazione.*, esame.PartitaIVAClinica "
                . "FROM prenotazione, esame "
                . "WHERE ((prenotazione.IDEsame='" . $idEsame . "') AND (esame.IDEsame=prenotazione.IDEsame) AND "
                . "(esame.PartitaIVAClinica='" . $partitaIVA . "') AND "
                . "(DATE(DataEOra)='" . $data . "')) LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Memorizza una prenotazione nel database.
     * 
     * @access public
     * @param EPrenotazione $ePrenotazione L'entita prentazione da memorizzare sul db
     * @return bool TRUE se memorizzao con successo, False altrimenti
     */
//    public function aggiungiPrenotazione($ePrenotazione) 
//    {
//        $valoriAttributi = $ePrenotazione->getValoriAttributi();
//        $query = "INSERT INTO " . $this->_nomeTabella . " (" . $this->_attributiTabella . ") VALUES(" . $valoriAttributi . ")";
//        return  $this->eseguiQuery($query);
//    }
    
//    public function cercaPrenotazioneById($id) {
//        
//        $query = "SELECT * "
//                . "FROM prenotazione "
//                . "WHERE IdPrenotazione = '" . $id . "' LOCK IN SHARE MODE";
//        return $this->eseguiQuery($query);
//        
//        
//    }
    
    /**
     * Metodo che consente di confermare una prenotazione 
     * 
     * @access public
     * @param string $idPrenotazione L'id della prenotazione
     * @return boolean TRUE se la conferma è avvenuta con successo
     */
//    public function confermaPrenotazione($idPrenotazione) 
//    {
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
//                " WHERE IDPrenotazione='" . $idPrenotazione . "' FOR UPDATE" ;
//        $query = "UPDATE " . $this->_nomeTabella . " SET Confermata=TRUE WHERE IDPrenotazione='" . $idPrenotazione . "'";
//        try {
//            // inzia la transazione
//            $this->_connessione->begin_transaction();
//
//            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
//            $this->eseguiquery($queryLock);
//            $this->eseguiQuery($query);
//
//            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        } 
//    }
    
    /**
     * Metodo che consente di eliminare la prenotazione passata per parametro
     * 
     * @access public
     * @param string $idPrenotazione L'id della prenotazione
     * @throws XDBException Se la query per eliminare la prenotazione specificata non è stata eseguita con successo
     * @return boolean TRUE se l'eliminazione è avvenuta con successo
     */
//    public function eliminaPrenotazione($idPrenotazione) 
//    {
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
//                " WHERE IDPrenotazione='" . $idPrenotazione . "' FOR UPDATE" ;
//        $query = 'DELETE FROM ' . $this->_nomeTabella .  " WHERE IDPrenotazione='" . $idPrenotazione . "'";
//        try {
//            // inzia la transazione
//            $this->_connessione->begin_transaction();
//
//            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
//            $this->eseguiquery($queryLock);
//            $this->eseguiQuery($query);
//
//            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        } 
//    }
    
    
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
     * @return array Il risultato della query multipla. Ogni elemento dell'array è una prenotazione
     * @throws XDBException Se c'è un errore durante l'esecuzione della query
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
                . "FROM prenotazione, esame "
                . "WHERE (esame.IDEsame='" . $idEsame . "' AND esame.IDEsame=prenotazione.IDEsame AND "
                . "esame.PartitaIVAClinica='" . $partitaIVA . "' AND "
                . "CodFiscaleUtenteEffettuaEsame='" . $cfUtente . "' AND "
                . "DATE(DataEOra)='" . $data . "') LOCK IN SHARE MODE;"// fine prima query.  //DATE(DataEOra) prendo solo la data di un datetime
                . "SELECT * "
                . "FROM prenotazione, esame "
                . "WHERE (CodFiscaleUtenteEffettuaEsame='" . $cfUtente . "' AND esame.IDEsame=prenotazione.IDEsame AND "
                . "DATE(DataEOra)='" . $data . "' AND "
                . "TIME(DataEOra) BETWEEN  '". $ora . "' AND '" . $ora2 . "') LOCK IN SHARE MODE"; // cerco tra inizio della prenotazione e la fine della prenotazione;
        return $this->eseguiQueryMultiple($queryMultipla);            
    }
    
    /**
     * Metodo che consente di modificare data e orario della prenotazione(già esistente)
     * di cui si passa come paramtro l'id.
     * 
     * @access public
     * @param string $idPrenotazione Identificativo della prenotazione da modificare
     * @param string $dataEOra Data e orario della prenotazione
     * @return boolean TRUE se la query è stata eseguita con successo
     * @throws XDBException Se la query non è stata eseguita con successo
     */
//    public function modificaPrenotazione($idPrenotazione, $dataEOra) 
//    {
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
//                " WHERE IDPrenotazione='" . $idPrenotazione . "' FOR UPDATE" ;
//        $query = "UPDATE " . $this->_nomeTabella . " SET DataEOra='" . $dataEOra . "' WHERE IDPrenotazione='" . $idPrenotazione . "'";
//        try {
//            // inzia la transazione
//            $this->_connessione->begin_transaction();
//
//            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
//            $this->eseguiquery($queryLock);
//            $this->eseguiQuery($query);
//
//            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        } 
//    }
    
    /**
     * Metodo che consente di modificare lo stato di esecuzione della prenotazione(ovvero se la prenotazione è stata eseguita o meno)
     * di cui si passa come paramtro l'id.
     * 
     * @access public
     * @param string $idPrenotazione Identificativo della prenotazione da modificare
     * @param boolean $eseguita La prenotazione è stata eseguita.
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la query è stata eseguita con successo
     */
//    public function modificaPrenotazioneEseguita($idPrenotazione, $eseguita)
//    {
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
//                " WHERE IDPrenotazione='" . $idPrenotazione . "' FOR UPDATE" ;
//        $query = "UPDATE " . $this->_nomeTabella . " SET Eseguita='" . $eseguita . "' WHERE IDPrenotazione='" . $idPrenotazione . "'";
//        try {
//            // inzia la transazione
//            $this->_connessione->begin_transaction();
//
//            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
//            $this->eseguiquery($queryLock);
//            $this->eseguiQuery($query);
//
//            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        } 
//    }
    
    
    /**
     * Metodo che consente di trovare tutte le prenotazioni che dovranno essere 
     * eseguite in una specifica data passata come parametro.
     * 
     * @access public
     * @param string $data La data in formato d-m-Y
     * @return array Array di prenotazioni che devo essere eseguite in quella data
     */
    public function cercaPrenotazioniData($data) 
    {
        $data = date('Y-m-d', strtotime($data));
        $query = "SELECT * "
                . "FROM prenotazione "
                . "WHERE (DATE(DataEOra)='" . $data . "') LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di cercare tutte le prenotazioni che un utente 
     * non ha effettuato fino ad una data passata come parametro.
     * 
     * @access public
     * @param string $cfUtente Il codice fiscale dell'utente
     * @param string $dataOdierna  La data odiernam in formato Y-m-d
     * @return array Array di prenotazioni 
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function cercaPrenotazioniNonEffettuate($cfUtente, $dataOdierna)
    {
        $query = "SELECT * "
                . "FROM prenotazione "
                . "WHERE (CodFiscaleUtenteEffettuaEsame='" . $cfUtente . "' AND "
                . "Eseguita=FALSE AND "
                . "DATE(DataEOra)<'" . $dataOdierna . "') LOCK IN SHARE MODE";
        $risultato = $this->eseguiQuery($query);
        return  $risultato;
    }
}
