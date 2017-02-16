<?php

/**
 * La classe FReferto si occupa della gestione della tabella 'referto'.
 *
 * @package Foundation
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
        $this->_nomeColonnaPKTabella = "IDReferto";
        $this->_attributiTabella = "IDReferto, IDPrenotazione, FileName, " .
                "Contenuto, MedicoReferto, DataReferto, CondivisoConMedico, CondivisoConUtente";
    }
    
    /**
     * Permette di trovare tutti i referti dei clienti di una data clinica.
     * 
     * @access public
     * @param string $partitaIVAClinica la partita iva della clinica
     * @return array Array contenente i referti cercati
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaRefertiClinica($partitaIVAClinica) 
    {
        
        $query =   "SELECT referto.IDReferto, esame.IDEsame, prenotazione.IDPrenotazione, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DATE_FORMAT(referto.DataReferto,'%d-%m-%Y') AS DataReferto, prenotazione.CodFiscaleUtenteEffettuaEsame "
                . "FROM referto, prenotazione, esame, utente "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(esame.PartitaIVAClinica='" . $partitaIVAClinica . "')) LOCK IN SHARE MODE";
        $risultato =  $this->eseguiQuery($query);
        return $risultato;
//        return $this->eseguiQuery($query);
        
    }
    
    
    /**
     * Metodo che consente di cercare tutti i referti di un utente il cui 
     * codice fiscale è passato come parametro.
     * 
     * @access public
     * @param string $codiceFiscale Il codice fiscale dell'utente di cui cercare i referti
     * @return array I referti dell'utente
     * @throws XDBException Se la query non è stata eseguita con successo
     * 
     */
    public function cercaRefertiUtente($codiceFiscale)
    {
        $query =   "SELECT IDReferto, prenotazione.IDPrenotazione, esame.IDEsame, esame.NomeEsame, clinica.NomeClinica,  "
                . "DATE_FORMAT(DataReferto,'%d-%m-%Y') AS DataReferto "
                . "FROM referto, prenotazione, esame, clinica "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame='" . $codiceFiscale . "') AND "
                . "(esame.PartitaIVAClinica=clinica.PartitaIVA)) LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Permette di trovare tutti referti relativi ai pazienti di un dato medico.
     * 
     * @access public
     * @param string $cfMedico codice fiscale del medico 
     * @return array I referti dei pazienti del medico
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaRefertiPazientiMedico($cfMedico) 
    {
        $query =   "SELECT IDReferto, referto.IDPrenotazione, esame.NomeEsame, clinica.NomeClinica, utente.Nome, utente.Cognome, prenotazione.CodFiscaleUtenteEffettuaEsame, "
                . "DATE_FORMAT(DataReferto,'%d-%m-%Y') AS DataReferto  "
                . "FROM referto, prenotazione, esame, utente, clinica "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (prenotazione.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND (esame.PartitaIVAClinica=clinica.PartitaIVA) AND "
                . "(utente.CodFiscaleMedico='" . $cfMedico . "') AND referto.CondivisoConMedico=TRUE) LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti i valori degli attibuti necessari
     * per l'inserimento di una referto nel database.
     * 
     * @access private
     * @param EReferto $referto il referto di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    private function getAttributi($referto) {      
        $valoriAttributi = "'" . $referto->getIDRefertoReferto() . "', '" 
                . $this->trimEscapeStringa($referto->getIDPrenotazioneReferto()) . "', '"
                . $referto->getFileNameReferto() . "', '"  
                . $referto->getContenutoReferto() . "', '"  
                . $this->trimEscapeStringa($referto->getMedicoRefertoReferto()) . "', '" 
                . $referto->getDataRefertoReferto() . "', ";
        
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
                print_r($valoriAttributi);     
       
        return $valoriAttributi;
    }
    
    /**
     *  Metodo per inserire nella tabella Referto una nuova riga ovvero
     * una nuovo referto.
     * 
     * @param EReferto $referto l'entità referto da inserire nel db
     * @return bool TRUE se l'iserimento è avvenuto con successo
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function inserisciReferto($referto) {
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($referto);
        $query = "INSERT INTO ". $this->_nomeTabella ." ( ". $this->_attributiTabella .") VALUES( ". $valoriAttributi . ")";
        return $this->eseguiQuery($query);
    }
    
    
    /**
     * Controlla se il file esiste nel file system.
     * 
     * @access public
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
//    public function cercaReferto($idPrenotazione) 
//    {
//        $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE IDPrenotazione='" . $idPrenotazione . "' LOCK IN SHARE MODE";
//        return $this->eseguiQuery($query);
//    }
    
    
    /**
     * Metodo che consente di condividere un referto passato come parametro con il proprio medico curante
     * 
     * @access public
     * @param string $idReferto L'id del referto
     * @param boolean $condividi TRUE se si vuole la condivisione del referto con il medico, FALSE altrimenti
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
//    public function condividiConMedico($idReferto, $condividi ) {
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
//                . " WHERE IDReferto= '" . $idReferto . "' FOR UPDATE" ;
//        $query= "UPDATE " . $this->_nomeTabella 
//                . " SET CondivisoConMedico='" . $condividi . "' "
//                . "WHERE IDReferto= '" . $idReferto . "'";
//        try {
//           $this->_connessione->begin_transaction();
//            $this->eseguiQuery($queryLock);
//            $this->eseguiQuery($query);
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        }
//    }
}
