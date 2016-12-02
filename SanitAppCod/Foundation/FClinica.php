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
class FClinica extends FUser{
    
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
                . "NumCivico, CAP, Località, Provincia, Regione, Username, PEC, Telefono, "
                . "CapitaleSociale"; 
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di una clinica nel database
     * 
     * @access public
     * @param EClinica $clinica la Clinica di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($clinica) 
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
                . $this->trimEscapeStringa($clinica->getUsernameClinica()) .  "', '"
                . $this->trimEscapeStringa($clinica->getPECClinica()) .  "', '"
                . $clinica->getTelefonoClinica() .  "', '" 
                . $clinica->getCapitaleSocialeClinica() . "'";
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
        $valoriAttributiUser = parent::getAttributi($clinica);
    
        $query1 = "INSERT INTO appuser (Username, Password, Email, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ", 'medico')";
        $query2 = "INSERT INTO " . $this->_nomeTabella . " ( ". $this->_attributiTabella . ") VALUES( " . $valoriAttributi . ")";
        try {
            // First of all, let's begin a transaction
            $this->_connessione->begin_transaction();

            // A set of queries; if one fails, an exception should be thrown
             $this->eseguiquery($query1);
             $this->eseguiQuery($query2);

            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            $this->_connessione->commit();
        } catch (Exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $this->_connessione->rollback();
        }
    }


// da modificare in base ai casi d'uso :(

    
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
        $query = "SELECT appuser.*, " .  $this->_nomeTabella . ".* "
                . "FROM appuser," . $this->_nomeTabella . " WHERE (PartitaIVA ='" . $partitaIVA . "' AND "
                . "appuser.Username=clinica.Username)";
        return $this->eseguiQuery($query);

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
        $query = "SELECT appuser.*, " .  $this->_nomeTabella . ".* "
                . "FROM appuser," . $this->_nomeTabella . " WHERE (clinica.Username ='" . $username . "' AND "
                . "appuser.Username=clinica.Username)";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    /**
     * Metodo che consente di trovare la clinica la cui PEC è passata come
     * parametro
     * 
     * @access public
     * @param string $PEC La PEC della clinica
     * @return Array|boolean Array contenente solo la clinica cercata, FALSE altrimenti
     */
    public function cercaClinicaByPEC($PEC) 
    {
        $query = "SELECT appuser.*, " .  $this->_nomeTabella . ".* "
                . "FROM appuser," . $this->_nomeTabella . " WHERE (clinica.PEC ='" . $PEC . "' AND "
                . "appuser.Username=clinica.Username)";
        return $this->eseguiQuery($query); 
    }
    
    /**
     * Metodo che permette di effettuare la ricerca di cliniche 
     * 
     * @param string $luogo Il luogo in cui si trova la clinica
     * @param string $nome Il nome della clinica che si vuole cercare
     * @return array|boolean Se la query è stata eseguita con successo, in caso contrario resituirà FALSE.
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
            if(!empty($luogo))
            {
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
                $query =  "SELECT NomeClinica, Località, Provincia, "
                        . "MATCH (NomeClinica) AGAINST ('$nome' IN BOOLEAN MODE) "
                        . "FROM clinica "
                        . "WHERE MATCH (NomeClinica) AGAINST('$nome' IN BOOLEAN MODE)";
            }
        }
        else
        {
            if(!empty($luogo))
            {
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
                $query = "SELECT NomeClinica, Località, Provincia, PartitaIVA FROM clinica";
            }
        }        
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
        
        return $this->eseguiQuery($query);
        
    }
    
    
    /**
     * Metodo che permette di conoscere quali sono i clienti di una clinica
     * 
     * @access public
     * @param string $usernameClinica L'username della clinica 
     * @return type Description
     */
    public function cercaClienti($usernameClinica) 
    {
        $query1=  "SELECT prenotazione.CodFiscaleUtenteEffettuaEsame AS CodFiscale "
                . "FROM prenotazione, clinica "
                . "WHERE clinica.PartitaIVA=prenotazione.PartitaIVAClinica AND clinica.Username='" . $usernameClinica . "'";
        $query2 = "SELECT appuser.Email, utente.Nome, utente.Cognome, utente.Via, utente.NumCivico, utente.CAP, utente.CodFiscale  "
                . "FROM utente, appuser "
                . "WHERE utente.Username=appuser.Username";
        $query =  "SELECT * "
                . "FROM (" . $query1 .")t1 "
                . "INNER JOIN (" . $query2 . ")t2 "
                . "ON t1.CodFiscale=t2.CodFiscale";
        return $this->eseguiQuery($query);        
    }
    
    /**
     * Metodo che consente di cercare gli appuntamenti giornalieri di una clinica passata come paramentro
     * 
     * @access public
     * @param string $partitaIVAClinica La partita IVA della clinica di cui si vogliono cercare gli appuntamenti
     * @param string $start Stringa contenente data e ora in formato YYYY-MM-DD hh:mm da cui bisogna inziare il recupero
     * @param string $end Stringa contenente data e ora in formato YYYY-MM-DD hh:mm fino cui bisogna effettuare il recupero
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaAppuntamenti($partitaIVAClinica, $start, $end) {
//        $dataStart = substr($start, 0, 10); // solo la data
//        $dataEnd = substr($end, 0, 10);
//        $oraStart = substr($start, 11, 5);
//        $oraEnd = substr($end, 11, 5);
        
//        $dataOdierna = date('Y-m-d');  // stringa contenente la data odierna
//        $dataOdierna = "2016-11-30";// da eliminare serve solo per vedere se la query funziona
        $query = "SELECT IDPrenotazione, esame.NomeEsame, utente.Nome, utente.Cognome, TIME(DataEOra) as Orario, DATE(DataEOra)as Data, esame.Durata "
                . "FROM prenotazione,esame,utente "
                . "WHERE prenotazione.PartitaIVAClinica='" . $partitaIVAClinica . "' AND "
                . "prenotazione.IDEsame=esame.IDEsame AND "
                . "prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale AND "
//                . "DATE(DataEOra)='" . $dataOdierna . "'";
                . "DataEOra>='" . $start . "' AND "
                . "DataEOra<='" . $end . "'";
        print_r($query);
        return $this->eseguiQuery($query);
    }
    
    
    
}
