<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FClinica
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FClinica extends FDatabase{
    
    /**
     * Costruttore della classe FClinica
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "clinica";
        $this->_attributiTabella = "PartitaIVA, NomeClinica, Titolare, Via, " 
                . "NumCivico, CAP, Località, Provincia, Regione, Email, Username, Password, PEC, Telefono, "
                . "CapitaleSociale, OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
                . "OrarioChiusuraPM, OrarioContinuato, Confermato, CodiceConferma"; 
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di una clinica nel database
     * 
     * @access private
     * @param EClinica $clinica la Clinica di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    private function getAttributi($clinica) 
    {
        $valoriAttributi = "'" . $this->trimEscapeStringa($clinica->getPartitaIVAClinica()) . "', '" 
                . $this->trimEscapeStringa($clinica->getNomeClinica()) . "', '" 
                . $this->trimEscapeStringa($clinica->getTitolareClinica()) .  "', '" 
                . $this->trimEscapeStringa($clinica->getViaClinica()). "', '" 
                . $clinica->getNumeroCivicoClinica() . "', '" 
                . $this->trimEscapeStringa($clinica->getCAPClinica()) . "', '" 
                . $this->trimEscapeStringa($clinica->getLocalitàClinica()). "', '"
                . $this->trimEscapeStringa($clinica->getProvinciaClinica()). "', '"
                . $this->trimEscapeStringa($clinica->getRegioneClinica()). "', '"
                . $this->trimEscapeStringa($clinica->getEmailClinica()) .  "', '"  
                . $this->trimEscapeStringa($clinica->getUsernameClinica()) .  "', '" 
                . $this->trimEscapeStringa($clinica->getPasswordClinica()) .  "', '"
                . $this->trimEscapeStringa($clinica->getPECClinica()) .  "', '"
                . $clinica->getTelefonoClinica() .  "', '" 
                . $clinica->getCapitaleSocialeClinica() . "', '" 
                . $clinica->getOrarioAperturaAMClinica() . "', '" 
                . $clinica->getOrarioChiusuraAMClinica() . "', '" 
                . $clinica->getOrarioAperturaPMClinica() .  "', '" 
                . $clinica->getOrarioChiusuraPMClinica() . "', '" 
                . $clinica->getOrarioContinuatoClinica() .  "', '"
                . $clinica->getConfermatoClinica() .  "', '"
                . $clinica->getCodiceConfermaClinica() .  "'" ;
        return $valoriAttributi;
    }
    
    /**
     * Metodo per inserire nella tabella Clinica una nuova riga ovvero
     * una nuova clinica
     * 
     * @param EClinica $clinica L'oggetto di tipo EClinica che si vuole salvare nella
     *                       tabella Clinica
     */
    public function inserisciClinica($clinica)
    {         
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($clinica);
        
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO " . $this->_nomeTabella . " (" . $this->_attributiTabella . ") VALUES(" . $valoriAttributi . ")";
        // eseguo la query
        $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di cercare la partita IVA della clinica il cui nome
     * è passato come paramentro 
     * 
     * @access public
     * @param string $nomeClinica Il nome della clinica
     * @return string|boolean Il codice fiscale della clinica, FALSE altrimenti.
     */
    public function cercaPartitaIVAClinica($nomeClinica)
    {
        $nomeClinica = $this->trimEscapeStringa($nomeClinica);
        $query = "SELECT PartitaIVA,"
                . "MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE) "
                . "FROM " . $this->_nomeTabella . " WHERE ((NomeClinica='" . $nomeClinica . "') "
                . "AND (MATCH (NomeClinica) AGAINST ('$nomeClinica' IN BOOLEAN MODE)))";
        $risultato = $this->eseguiQuery($query);
        if(is_array($risultato))
        {
            $codiceFiscaleClinica = $risultato[0]['PartitaIVA'];
        } 
        else
        {
            $codiceFiscaleClinica = FALSE;
        }
        return $codiceFiscaleClinica;
    }
    
    /**
     * Metodo che consente di trovare la clinica la cui partita IVA è passata come
     * parametro
     * 
     * @access public
     * @param string $partitaIVA La partitaIVA della clinica
     * @return Array|boolean Array contenente solo la clinica cercata, FALSE altrimenti
     */
    public function cercaClinicaByPartitaIVA($partitaIVA) 
    {
        $query = "SELECT * "
                . "FROM " . $this->_nomeTabella . " WHERE (PartitaIVA ='" . $partitaIVA. "')";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    /**
     * Metodo che consente di trovare la clinica il cui username è passato come
     * parametro
     * 
     * @access public
     * @param string $username L'username della clinica
     * @return Array|boolean Array contenente solo la clinica cercata, FALSE altrimenti
     */
    public function cercaClinicaByUsername($username) 
    {
        $query = "SELECT *,"
                . "MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE) "
                . "FROM " . $this->_nomeTabella . " WHERE (MATCH (Username) AGAINST ('$username' IN BOOLEAN MODE))";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    /**
     * Metodo che permette di effettuare la ricerca di cliniche 
     * 
     * @param string $luogo Il luogo in cui si trova la clinica
     * @param string $nome Il nome della clinica che si vuole cercare
     * @return array|boolean Se la query è stata eseguita con successo, ..., in caso contrario resituirà false.
     */
    public function cercaClinica($nome, $luogo)
    {
        if($nome == "all")
        {
            $nome = "";
        }
        else
        {
            $nome = str_replace("_", " ", $nome);
        }
        if($luogo == "all")
        {
            $luogo = "";
        }
        else
        {
            $luogo = str_replace("_", " ", $luogo);
        }
        
        if(!empty($nome))
        {
            echo "si nomeClinica";
            if(!empty($luogo))
            {
                echo " si nomeClinica, luogo";
                $query =  "SELECT NomeClinica, Località, Provincia, "
                        . "MATCH (NomeClinica) AGAINST ('$nome' IN BOOLEAN MODE), "
                        . "MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (CAP) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (Regione) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "FROM clinica "
                        . "WHERE (MATCH (NomeClinica) AGAINST('$nome' IN BOOLEAN MODE) "
                        . "AND (MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (Regione) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))";
            }
            else
            {  
                echo " si nomeClinica, no luogo";
                $query =  "SELECT NomeClinica, Località, Provincia, "
                        . "MATCH (NomeClinica) AGAINST ('$nome' IN BOOLEAN MODE) "
                        . "FROM clinica "
                        . "WHERE MATCH (NomeClinica) AGAINST('$nome' IN BOOLEAN MODE)";
            }
        }
        else
        {
            echo "no nomeClinica";
            if(!empty($luogo))
            {
                echo "no nomeClinica, si luogo";
                $query =  "SELECT NomeClinica, Località, Provincia, "
                        . "MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (Regione) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (CAP) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "FROM clinica "
                        . "WHERE (MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (Regione) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (CAP) AGAINST ('$luogo' IN BOOLEAN MODE))";
            }
            else
            {
                echo "no nomeClinica, no luogo";
                $query = "SELECT NomeClinica, Località, Provincia FROM clinica";
            }
        }
        
        
        /* vecchia versione
        if (!empty($luogo)&& !empty($nome))
        {
            $query = "SELECT * FROM ".$this->_nomeTabella." WHERE NomeClinica = '"
                    . $nome . "' AND (Località =  '" . $luogo ."' OR Provincia='" . $luogo . "' OR CAP='" . $luogo . "')";
        }
        elseif(!empty ($luogo))
        {
            $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE (Località =  '" 
                    . $luogo . "' OR Provincia='" . $luogo . "' OR CAP='" . $luogo . "')";
            
        }
        elseif (!empty($nome)) 
        {
            $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE NomeClinica = '"
                    . $nome . "'";
        }
        else
        {
            $query = "SELECT * FROM " . $this->_nomeTabella;
        }
        fine vecchia versione*/
        
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    /**
     * Metodo che consente il salvataggio del working plan
     * 
     * @access public
     * @param string $workingPlan il working plan della clinica
     * @param string $partitaIVAClinica La partita IVA della Clinica
     * @return type Description
     */
    public function salvaWorkingPlan($workingPlan,$partitaIVAClinica) 
    {
        $query="UPDATE clinica "
                . "SET WorkingPlan='" . $workingPlan . "' "
                . "WHERE PartitaIVA= '" . $partitaIVAClinica . "'";
        
//        $query = "UPDATE clinica SET WorkingPlan= 'Ciaociao' WHERE PartitaIVA = '12345'";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    /**
     * Metodo che permette di conoscere quali sono i clienti di una clinica
     * 
     * @access public
     * @param string $username L'username della clinica
     * @return Array Array contenente il risultato della query.
     */
    public function cercaClienti($username) 
    {
        $query =  "SELECT utente.CodFiscale, utente.Nome, utente.Cognome, utente.Via, utente.NumCivico, utente.CAP, utente.Email "
                . "FROM utente, clinica, prenotazione "
                . "WHERE ((utente.CodFiscale=prenotazione.CodFiscaleUtenteEffettuaEsame) AND "
                . "(clinica.PartitaIVA=prenotazione.PartitaIVAClinica) AND "
                . "(clinica.Username='" . $username . "'))";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
}
