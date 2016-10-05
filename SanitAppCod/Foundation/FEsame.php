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
        $this->_attributiTabella = "IDEsame, Nome, Descrizione, Prezzo, " .
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
        //devo trovare la partita IVA della clinica che vuole inserire l'esame
        $sessione = USingleton::getInstance('USession');
        $nomeClinica = $sessione->leggiVariabileSessione('nomeClinica');
        echo " nome clinica: " . $nomeClinica;
        $fClinica = USingleton::getInstance('FClinica');
        $partitaIVA = $fClinica->cercaPartitaIVAClinica($nomeClinica);
        
        
        
        $valoriAttributi = "'" . $esame->getIDEsame() . "', '" 
                . $this->trimEscapeStringa($esame->getNomeEsame()) . "', '" 
                . $this->trimEscapeStringa($esame->getDescrizioneEsame()) . "', '" 
                . $esame->getPrezzoEsame() . "', '" 
                . $esame->getDurataEsame() . "', '" 
                . $this->trimEscapeStringa($esame->getMedicoEsame()) . "', '" 
                . $esame->getNumeroPrestazioniSimultaneeEsame() . "', '"  
                . $this->trimEscapeStringa($esame->getNomeCategoriaEsame()) . "', '" 
                . $partitaIVA . "'"; 
                // manca la partita IVA della clinica;
        return $valoriAttributi;
    }
    
    
    /**
     * 
     * @param string $id L'id dell'esame da cercare
     * @return array|boolean un esame false se non ci sono esami
     */
    public function cercaEsameById($id) {
        
        $query = "SELECT *"
                . " FROM " . $this->_nomeTabella 
                . " WHERE esame.IDEsame = $id";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
        
    }
    
    
    /**
     * 
     * @param string $id L'id dell'esame da cercare
     * @return array|boolean un esame false se non ci sono esami
     */
    public function cercaEsameById($id) {
        
        $query = "SELECT *"
                . " FROM " . $this->_nomeTabella 
                . " WHERE esame.IDEsame = $id";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
        
    }
    
    
    /**
     * 
     * @param string $id L'id dell'esame da cercare
     * @return array|boolean un esame false se non ci sono esami
     */
    public function cercaEsameById($id) {
        
        $query = "SELECT *"
                . " FROM " . $this->_nomeTabella 
                . " WHERE esame.IDEsame = $id";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
        
    }

    /**
     * Metodo per inserire nella tabella Esame una nuova riga ovvero
     * una nuovo esame
     * 
     * @param EEsame $esame L'oggetto di tipo EEsame che si vuole salvare nella
     *                       tabella Esame
     */
    public function inserisciEsame($esame) {
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($esame);

        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO ". $this->_nomeTabella ." ( ". $this->_attributiTabella .") VALUES( ". $valoriAttributi . ")";
        // eseguo la query
        $this->eseguiQuery($query);
    }
    
    
    /**
     * 
     * @param string $id L'id dell'esame da cercare
     * @return array|boolean un esame false se non ci sono esami
     */
    public function cercaEsameById($id) {
        
        $query = "SELECT *"
                . " FROM " . $this->_nomeTabella 
                . " WHERE esame.IDEsame = $id";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
        
    }

    /**
     * Metodo che permette di effettuare la ricerca di esami 
     * 
     * @param string $nomeEsame Il nome dell'esame di cui si vuole fare la ricerca
     * @param string $nomeClinica Il nome della clinica in cui si vuole fare ricerca
     * @param string $luogo Il luogo in cui si trova la clinica
     * @return array|boolean Se la query è stata eseguita con successo, ..., in caso contrario resituirà false.
     */
    public function cercaEsame($nomeEsame="all", $nomeClinica="all", $luogo="all") {

//        $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                . "NomeCategoria, NomeClinica, clinica.Località"
//                . " FROM " . $this->_nomeTabella . ", clinica"
//                . " WHERE esame.PartitaIVAClinica = clinica.PartitaIVA";

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
            echo "si nomeesame";
            if (!empty($luogo) && !empty($nomeClinica)) 
            {
                echo "si nomeesame, nomeclinica, luogo";
                $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località, "
                            . "MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE), "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE)) "
                            . "AND (MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
//                $query .= " AND 'esame.Nome'='" . $nomeEsame . "' AND NomeClinica='"
//                        . $nomeClinica . "' AND ('clinica.Località'='"
//                        . $luogo . "' OR 'clinica.Provincia'='" . $luogo . "' OR "
//                        . "'clinica.CAP'='" . $luogo . "')";
            } 
            else 
            {

                if (!empty($nomeClinica)) {

                    if (empty($luogo)) {
                        echo "si nomeesame, nomeclinica , no luogo";
                        $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND (MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
                        

//                            . "MATCH (Nome, NomeClinica) AGAINST ('$nomeEsame,$nomeClinica' IN BOOLEAN MODE)"
//                            . "FROM esame, clinica WHERE MATCH (Nome, NomeClinica) AGAINST ('$nomeEsame, $nomeClinica' IN BOOLEAN MODE) "
//                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) "
//                        $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                            . "NumPrestazioniSimultanee, NomeCategoria, "
//                            . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                            . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                            . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                            . "OrarioChiusuraPM,OrarioContinuato "
//                            . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                            . "'esame.PartivaIVAClinica'='clinica.PartitaIVA "
//                            ." WHERE 'esame.Nome'='" . $nomeEsame . "' AND NomeClinica='"
//                            . $nomeClinica . "'";
                    }
                } 
                else 
                {
                    echo "si nomeesame, no nomeclinica, luogo";
                    if (empty($luogo)) {
//                        $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                            . "NumPrestazioniSimultanee, NomeCategoria, "
//                            . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                            . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                            . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                            . "OrarioChiusuraPM,OrarioContinuato "
//                            . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                            . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                            . " WHERE 'esame.Nome'='" . $nomeEsame . "'";
                        $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località, "
                                . "MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE)"
                                . "FROM esame, clinica WHERE MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE) "
                                . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
                    } 
                    else
                    {
                        echo "si nomeesame,luogo,  no nomeclinica ";
                        $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località, "
                            . "MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE), "                        
                            . "MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (Nome) AGAINST ('$nomeEsame' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
                        
//                        $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                                . "NumPrestazioniSimultanee, NomeCategoria, "
//                                . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                                . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                                . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                                . "OrarioChiusuraPM,OrarioContinuato "
//                                . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                                . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                                . " WHERE 'esame.Nome'='" . $nomeEsame . "' AND ('clinica.Località'='"
//                                . $luogo . "' OR 'clinica.Provincia'='" . $luogo . "' OR 'clinica.CAP'='" . $luogo . "')";
                    }
                }
            }
        } 
        else 
        {
            echo "no nomeesame ";
            if (!empty($nomeClinica)) 
            {
                echo "no nomeesame,  si nomeclinica ";
                if (empty($luogo))   
                {
                    echo "no nomeesame,luogo,  si nomeclinica ";
                    $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)"
                            . "FROM esame, clinica WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA)) ";
//                    $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                        . "NumPrestazioniSimultanee, NomeCategoria, "
//                        . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                        . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                        . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                        . "OrarioChiusuraPM,OrarioContinuato "
//                        . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                        . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                        . " WHERE NomeClinica='" . $nomeClinica . "'";
                    
                } 
                else 
                {
                    echo "no nomeesame,  si nomeclinica, luogo ";
//                    $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                            . "NomeCategoria, "
//                            . "NomeClinica, clinica.Località "
                            
//                            . "clinica.Provincia, clinica.CAP, "
//                    . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                    . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                    . "OrarioChiusuraPM,OrarioContinuato "
                    
//                            . "FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                            . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                            . " WHERE NomeClinica='" . $nomeClinica . "' "
//                            . "AND ('clinica.Località'='"
//                            . $luogo . "' OR 'clinica.Provincia'='" . $luogo . "' OR 'clinica.CAP'='" . $luogo . "')";
                            
                      $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località, "
                            . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)) "
                            . "AND ((MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";      
                }
            } 
            else 
            {
                echo "no nomeesame,  no nomeclinica ";
                if (!empty($luogo)) {
//                    
                    echo "no nomeesame,   nomeclinica, si luogo ";
                    $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località, "
                            . "MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                            . "MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                            . "FROM esame, clinica WHERE ((MATCH (clinica.Località) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Provincia) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.Regione) AGAINST ('$luogo' IN BOOLEAN MODE)) "
                            . "OR (MATCH (clinica.CAP) AGAINST ('$luogo' IN BOOLEAN MODE))) "
                            . "AND (esame.PartitaIVAClinica = clinica.PartitaIVA) ";

//                    $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                            . "NumPrestazioniSimultanee, NomeCategoria, "
//                            . "NomeClinica, clinica.Località"
//                            . " FROM " . $this->_nomeTabella . ", clinica WHERE esame.PartitaIVAClinica = clinica.PartitaIVA"
//. " AND (Località='" . $luogo . "' OR Provincia='"
//                            . $luogo . "' OR CAP='" . $luogo . "')";
//                            
//                    . " AND clinica.Località='" . $luogo . "'";
//                            ." OR clinica.Provincia=" 
//                    . $luogo . " OR clinica.CAP=" . $luogo . ")";
//                            clinica.Provincia, clinica.CAP, "
//                    . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                    . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
////                    . "OrarioChiusuraPM,OrarioContinuato "
//                    . " FROM " . $this->_nomeTabella
////                    ." INNER JOIN clinica ON "
////                    . "'esame.PartivaIVAClinica'='clinica.PartitaIVA' "
//                    . ", clinica WHERE esame.PartitaIVAClinica = clinica.PartitaIVA";
                } 
                else {
                    echo "no nomeesame,   nomeclinica,  luogo ";
                    $query = "SELECT IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, NomeCategoria, NomeClinica, clinica.Località "
                            . " FROM esame, clinica WHERE (esame.PartitaIVAClinica = clinica.PartitaIVA) ";
                }
            }
        }
        /* fine prova funzionante */

//        $risultato = $this->eseguiQuery("SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                        . "NumPrestazioniSimultanee, NomeCategoria, "
//                        . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                        . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                        . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                        . "OrarioChiusuraPM,OrarioContinuato "
//                        . " FROM esame INNER JOIN clinica;");
//        echo gettype($risultato);
//        $this->stampaRisultatoQuery($risultato);

        
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }

}
