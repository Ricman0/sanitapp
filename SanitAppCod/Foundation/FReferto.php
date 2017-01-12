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
        $this->_attributiTabella = "IDReferto, IDPrenotazione, IDEsame, PartitaIVAClinica, FileName, " .
                "Contenuto, MedicoReferto, DataReferto, CondivisoConMedico, CondivisoConUtente";
    }
    
    /**
     * Permette di trovare tutti i referti dei clienti di una data clinica
     * @param string $partitaIVAClinica la partita iva della clinica
     */
    public function cercaRefertiClinica($partitaIVAClinica) 
    {
        
        $query =   "SELECT IDReferto, esame.IDEsame, prenotazione.IDPrenotazione, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DATE_FORMAT(DataReferto,'%d-%m-%Y') AS DataReferto, prenotazione.CodFiscaleUtenteEffettuaEsame "
                . "FROM referto, prenotazione, esame, utente "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (referto.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(referto.PartitaIVAClinica='" . $partitaIVAClinica . "')) LOCK IN SHARE MODE";
        $risultato = $this->eseguiQuery($query);
//        print_r($risultato); // per il debug, da eliminare
        return $risultato;
        
    }
    
    
    /**
     * Metodo che consente di cercare tutti i referti di un utente il cui 
     * codice fiscale è passato come parametro
     * 
     * @access public
     * @param string $codiceFiscale Il codice fiscale dell'utente di cui cercare i referti
     * @return Array I referti dell'utente
     */
    public function cercaRefertiUtente($codiceFiscale)
    {
        $query =   "SELECT IDReferto, prenotazione.IDPrenotazione, esame.IDEsame, esame.NomeEsame, clinica.NomeClinica,  "
                . "DATE_FORMAT(DataReferto,'%d-%m-%Y') AS DataReferto "
                . "FROM referto, prenotazione, esame, clinica "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (referto.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscale . "') AND "
                . "(referto.PartitaIVAClinica=clinica.PartitaIVA)) LOCK IN SHARE MODE";
        $risultato = $this->eseguiQuery($query);
        return $risultato; 
    }
    
    /**
     * Permette di trovare tutti referti relativi ai pazienti di un dato medico
     * @param string $cfMedico codice fiscale del medico 
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return Array I referti dei pazienti del medico
     */
    public function cercaRefertiPazientiMedico($cfMedico) 
    {
        
        $query =   "SELECT IDReferto, esame.IDEsame, prenotazione.IDPrenotazione, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DATE_FORMAT(DataReferto,'%d-%m-%Y') AS DataReferto, prenotazione.CodFiscaleUtenteEffettuaEsame "
                . "FROM referto, prenotazione, esame, utente "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (referto.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(utente.CodFiscaleMedico='" . $cfMedico . "')) LOCK IN SHARE MODE";
        $risultato = $this->eseguiQuery($query);
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
                . $referto->getFileNameReferto() . "', '"  
                . $referto->getContenutoReferto() . "', '"  
                . $this->trimEscapeStringa($referto->getMedicoReferto()) . "', '" 
                . $referto->getDataReferto() . "', ";
                
                // manca la partita IVA della clinica;
        
        if ($referto->getCondivisoConMedicoReferto()===TRUE)
                {
                    $valoriAttributi = $valoriAttributi . $referto->getCondivisoConMedicoReferto();
                }
                else
                {
                     $valoriAttributi = $valoriAttributi .  "FALSE";
                }
                if ($referto->getCondivisoConUtenteReferto()!== NULL)
                {
                    $valoriAttributi = $valoriAttributi . ", '" . $this->trimEscapeStringa($referto->getCondivisoConUtenteReferto()) . "' ";
                }
                else
                {
                     $valoriAttributi = $valoriAttributi .  ", NULL ";
                }
                
       
        return $valoriAttributi;
    }
    
    /**
     *  Metodo per inserire nella tabella Referto una nuova riga ovvero
     * una nuovo referto
     * 
     * @param EReferto $referto l'entità referto da inserire nel db
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return bool TRUE se l'iserimento è avvenuto con successo
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
    
    
    /**
     * NON IN USO Controlla se il file esiste 
     * @param string $nomeFile Il nome del file da controllare
     * @return bool TRUE se il file esiste, FALSE altrimenti
     */
    public function checkEsistenzaReferto($nomeFile) {
        
        return file_exists($nomeFile);
        
    }
    
    /**
     * Metodo che consente di cercare il referto attraverso l'id della prenotazione
     * 
     * @access public
     * @param string $idPrenotazione Id della prenotazione
     * @return mixed Il risultato della query Array se esiste, boolean altrimenti
     */
    public function cercaReferto($idPrenotazione) 
    {
        $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE IDPrenotazione='" . $idPrenotazione . "' LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    
    /**
     * Metodo che consente di condividere un referto passato come parametro con il proprio medico curante
     * 
     * @access public
     * @param string $idReferto L'id del referto
     * @param boolean $condividi TRUE se si vuole la condivisione del referto con il medico, FALSE altrimenti
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function condividiConMedico($idReferto, $condividi ) {
        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
                . " WHERE IDReferto= '" . $idReferto . "' FOR UPDATE" ;
        $query= "UPDATE " . $this->_nomeTabella 
                . " SET CondivisoConMedico='" . $condividi . "' "
                . "WHERE IDReferto= '" . $idReferto . "'";
        try {
//            // First of all, let's begin a transaction
           $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock);
            // A set of queries; if one fails, an exception should be thrown
            $this->eseguiQuery($query);
             

            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            return $this->_connessione->commit();
        } catch (Exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }
    }
}
