<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FEsame
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FEsame extends FDatabase {

    /**
     * Costruttore della classe FEsame
     * 
     * @access public
     */
    public function __construct() {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "esame";
        $this->_idTabella = "IDEsame";
        $this->_attributiTabella = "IDEsame, NomeEsame, Descrizione, Prezzo, " .
                "Durata, MedicoEsame, NumPrestazioniSimultanee, " .
                "NomeCategoria, PartitaIVAClinica, Eliminato";
    }

    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di una esame nel database
     * 
     * @access private
     * @param EEsame $esame l'esame di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    private function getAttributi($esame) {
        $valoriAttributi = "'" . $esame->getIDEsameEsame() . "', '" 
                . $this->trimEscapeStringa($esame->getNomeEsameEsame()) . "', '" 
                . $this->trimEscapeStringa($esame->getDescrizioneEsame()) . "', '" 
                . $esame->getPrezzoEsame() . "', '" 
                . $esame->getDurataEsame() . "', '" 
                . $this->trimEscapeStringa($esame->getMedicoEsameEsame()) . "', '" 
                . $esame->getNumPrestazioniSimultaneeEsame() . "', '"  
                . $this->trimEscapeStringa($esame->getNomeCategoriaEsame()) . "', '" 
                . $esame->getPartitaIVAClinicaEsame() . "', ";
        if ($esame->getEliminatoEsame()===TRUE)
        {
            $valoriAttributi = $valoriAttributi . $esame->getEliminatoEsame();
        }
        else
        {
             $valoriAttributi = $valoriAttributi .  "FALSE";
        }
                
        return $valoriAttributi;
    }

    /**
     * Metodo per inserire nella tabella Esame una nuova riga ovvero
     * una nuovo esame
     * 
     * @param EEsame $esame L'oggetto di tipo EEsame che si vuole salvare nella
     *                       tabella Esame
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se è stato inserito con successo l'esame
     */
    public function inserisciEsame($esame) {
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($esame);

        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO ". $this->_nomeTabella ." ( ". $this->_attributiTabella .") VALUES( ". $valoriAttributi . ")";
        // eseguo la query
        return $this->eseguiQuery($query);
    }
    
    
    /**
     * 
     * @param string $id L'id dell'esame da cercare
     * @return array|boolean un esame false se non ci sono esami
     */
    public function cercaEsameById($id) {
        
        $query =  "SELECT * "
                . "FROM esame " 
                . "WHERE IDEsame ='" . $id . "' LOCK IN SHARE MODE";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
        
    }

    /**
     * Metodo che permette di effettuare la ricerca di esami 
     * 
     * @param string $nomeEsame Il nome dell'esame di cui si vuole fare la ricerca
     * @param string $nomeClinica Il nome della clinica in cui si vuole fare ricerca
     * @param string $luogo Il luogo in cui si trova la clinica
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return array|boolean Se la query è stata eseguita con successo, ..., in caso contrario resituirà false.
     */
    public function cercaEsame($nomeEsame="all", $nomeClinica="all", $luogo="all") 
    {
        if ($nomeEsame === "all") 
        {
            $nomeEsame = "";
        } 
        else 
        {
            $nomeEsame = str_replace("_", " ", $nomeEsame);
        }
        if ($nomeClinica === "all") 
        {
            $nomeClinica = "";
        } 
        else 
        {
            $nomeClinica = str_replace("_", " ", $nomeClinica);
        }
        if ($luogo === "all") 
        {
            $luogo = "";
        } 
        else
        {
            $luogo = str_replace("_", " ", $luogo);
        }
        if (!empty($nomeEsame)) 
        {
            if (!empty($luogo) && !empty($nomeClinica)) 
            {
                $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE), "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica, appuser WHERE ((MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE)) "
                            . "AND (MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) AND esame.Eliminato=FALSE AND appuser.Bloccato=FALSE AND appuser.Username=clinica.Username  LOCK IN SHARE MODE";
            } 
            else 
            {
                if (!empty($nomeClinica)) 
                {
                    if (empty($luogo)) 
                    {
                        $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE) "
                            . "FROM esame, clinica, appuser WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND (MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) AND esame.Eliminato=FALSE AND appuser.Bloccato=FALSE AND appuser.Username=clinica.Username LOCK IN SHARE MODE";
                    }
                } 
                else 
                {
                    if (empty($luogo)) 
                    {
                        $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                                . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE)"
                                . "FROM esame, clinica, appuser WHERE MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE) "
                                . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) AND esame.Eliminato=FALSE AND appuser.Bloccato=FALSE AND appuser.Username=clinica.Username LOCK IN SHARE MODE";
                    } 
                    else
                    {
                        $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE), "                        
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica, appuser WHERE ((MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) AND esame.Eliminato=FALSE AND (appuser.Bloccato=FALSE AND appuser.Username=clinica.Username) LOCK IN SHARE MODE";
                    }
                }
            }
        } 
        else 
        {
            if (!empty($nomeClinica)) 
            {
                if (empty($luogo))   
                {
                    $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)"
                            . "FROM esame, clinica, appuser WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) AND esame.Eliminato=FALSE AND appuser.Bloccato=FALSE AND appuser.Username=clinica.Username) LOCK IN SHARE MODE";                    
                } 
                else 
                {
                      $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica, appuser WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) AND esame.Eliminato=FALSE AND (appuser.Bloccato=FALSE AND appuser.Username=clinica.Username) LOCK IN SHARE MODE";      
                }
            } 
            else 
            {
                if (!empty($luogo)) 
                {
                    $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica, appuser WHERE ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) AND esame.Eliminato=FALSE AND (appuser.Bloccato=FALSE AND appuser.Username=clinica.Username) LOCK IN SHARE MODE";
                } 
                else 
                {
                    $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, TIME_FORMAT(Durata, '%H:%i') AS Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita "
                            . " FROM esame, clinica, appuser WHERE (appuser.Bloccato=FALSE AND appuser.Username=clinica.Username AND esame.Eliminato=FALSE AND esame.PartitaIVAClinica = clinica.PartitaIVA ) LOCK IN SHARE MODE";
                }
            }
        }
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }

    /**
     * Metodo che permette di cercare tutti gli esami che possiedono una determinata categoria.
     * 
     * @access public
     * @param string $nomeCategoria Il nome della categoria 
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return Array Esami che hanno la categoria passata come parametro
     */
    public function cercaEsamiByCategoria($nomeCategoria) {
        $query =  "SELECT * "
                . "FROM esame " 
                . "WHERE NomeCategoria ='" . $nomeCategoria . "' LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di modificare gli attributi dell'esame
     * 
     * @access public
     * @param EEsame $esame L'esame da modificare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function modificaEsame($esame) {
        
        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
                " WHERE (IDEsame='" . $esame->getIDEsameEsame() . "') FOR UPDATE" ;
        $query = "UPDATE " . $this->_nomeTabella . " SET NomeEsame='" . $esame->getNomeEsameEsame() .  "', Descrizione='"
                . $esame->getDescrizioneEsame() . "', Prezzo=" . $esame->getPrezzoEsame() . ", Durata='" . $esame->getDurataEsame() . "', "
                . "MedicoEsame='" . $esame->getMedicoEsameEsame() . "', NomeCategoria='" . $esame->getNomeCategoriaEsame() . "' "
                . "WHERE (IDEsame='" . $esame->getIDEsameEsame() . "')";
        try {
            // inzia la transazione
            $this->_connessione->begin_transaction();

            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
            $this->eseguiquery($queryLock);
            $this->eseguiQuery($query);

            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
            return $this->_connessione->commit();
        } catch (Exception $e) {
            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
            $this->_connessione->rollback();
            throw new XDBException('errore');
        } 
            
          
    }
    
    /**
     * Metodo che consente di eliminare l'esame settando come eliminato l'esame
     * 
     * @access public
     * @param string $idEsame L'id dell'esame da eliminare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function eliminaEsame($idEsame) {
        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
                " WHERE (IDEsame='" . $idEsame . "') FOR UPDATE" ;
        
        $query = "UPDATE " . $this->_nomeTabella . " SET Eliminato=TRUE "
                . "WHERE (IDEsame='" . $idEsame. "')";
        try {
            // inzia la transazione
            $this->_connessione->begin_transaction();

            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
            $this->eseguiquery($queryLock);
            $this->eseguiQuery($query);

            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
            return $this->_connessione->commit();
        } catch (Exception $e) {
            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
            $this->_connessione->rollback();
            throw new XDBException('errore');
        } 
    }
}

