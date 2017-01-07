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
        $this->_attributiTabella = "IDEsame, NomeEsame, Descrizione, Prezzo, " .
                "Durata, MedicoEsame, NumPrestazioniSimultanee, " .
                "NomeCategoria, PartitaIVAClinica";
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
        $valoriAttributi = "'" . $esame->getIDEsame() . "', '" 
                . $this->trimEscapeStringa($esame->getNomeEsame()) . "', '" 
                . $this->trimEscapeStringa($esame->getDescrizioneEsame()) . "', '" 
                . $esame->getPrezzoEsame() . "', '" 
                . $esame->getDurataEsame() . "', '" 
                . $this->trimEscapeStringa($esame->getMedicoEsame()) . "', '" 
                . $esame->getNumeroPrestazioniSimultaneeEsame() . "', '"  
                . $this->trimEscapeStringa($esame->getNomeCategoriaEsame()) . "', '" 
                . $esame->getPartitaIVAClinicaEsame() . "'"; 
                
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
                . "WHERE IDEsame ='" . $id . "'";
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
                $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE), "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE)) "
                            . "AND (MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
            } 
            else 
            {
                if (!empty($nomeClinica)) 
                {
                    if (empty($luogo)) 
                    {
                        $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND (MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
                    }
                } 
                else 
                {
                    if (empty($luogo)) 
                    {
                        $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                                . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE)"
                                . "FROM esame, clinica WHERE MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE) "
                                . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
                    } 
                    else
                    {
                        $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE), "                        
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (NomeEsame) AGAINST ('$nomeEsame' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
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
                    $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)"
                            . "FROM esame, clinica WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA)) ";                    
                } 
                else 
                {
                      $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";      
                }
            } 
            else 
            {
                if (!empty($luogo)) 
                {
                    $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita, "
                            . "MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (clinica.Localita) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
                } 
                else 
                {
                    $query = "SELECT IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Localita "
                            . " FROM esame, clinica WHERE (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
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
                . "WHERE NomeCategoria ='" . $nomeCategoria . "'";
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
        $query = "UPDATE " . $this->_nomeTabella . " SET NomeEsame='" . $esame->getNomeEsame() .  "', Descrizione='"
                . $esame->getDescrizioneEsame() . "', Prezzo=" . $esame->getPrezzoEsame() . ", Durata='" . $esame->getDurataEsame() . "', "
                . "MedicoEsame='" . $esame->getMedicoEsame() . "', NomeCategoria='" . $esame->getNomeCategoriaEsame() . "' "
                . "WHERE (IDEsame='" . $esame->getIDEsame() . "')";
        return $this->eseguiQuery($query);
            
          
    }
}
