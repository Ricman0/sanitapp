<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FMedico
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FMedico extends FUser {
    
    /**
     * Costruttore della classe FMedico
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FUser
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "medico";
        $this->_attributiTabella = "CodFiscale, Nome, Cognome, Via, NumCivico, "
                . "CAP, Username, ProvinciaAlbo, NumIscrizione, Validato";
    }
    
    /**
     * Metodo per inserire nella tabella Medico una nuova riga ovvero
     * un nuovo medico
     * 
     * @param EMedico $medico L'oggetto di tipo EMedico che si vuole salvare nella
     *                       tabella Medico
     */
    public function inserisciMedico($medico)
    {
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($medico);
        $valoriAttributiUser = parent::getAttributi($medico);

        

       // di default il db è impostato in autocommit
        // per disabilitare l'autocommit solo per alcune istruzioni non eseguire  SET autocommit=0;
        // ma eseguire START TRANSACTION
//        $query = " START TRANSACTION"; "INSERT INTO appUser (Username, Password, Email, Confermato,CodiceConferma,TipoUser) VALUES( " .  $valoriAttributiUser . "'medico')";
//        "INSERT INTO " . $this->_nomeTabella . " ( ". $this->_attributiTabella .") VALUES( " . $valoriAttributi . ")";
//     
//        "COMMIT";
//        
        //oppure
        
        $query1 = "INSERT INTO appuser (Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ", 'medico')";
        $query2 = "INSERT INTO medico ( CodFiscale, Nome, Cognome, Via, NumCivico, "
                . "CAP, Username, ProvinciaAlbo, NumIscrizione, Validato) VALUES( " . $valoriAttributi . ")";
       
        try {
            // First of all, let's begin a transaction
            $this->_connessione->begin_transaction();

            // A set of queries; if one fails, an exception should be thrown
             $this->eseguiquery($query1);
             $this->eseguiQuery($query2);

            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            return $this->_connessione->commit();
        } catch (Exception $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $this->_connessione->rollback();
        }

        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        // eseguo la query
//        if ($this->eseguiQuery($query)===TRUE)
//        {
//            echo " FMedico inseritooo ";
//            return TRUE;
//        }
//        else 
//        {
//            echo " FMedico non inseritooo ";
//            return FALSE;
//        }
    }
    
    /** 
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di un medico nel database
     * 
     * @access public
     * @param EMedico $medico Il medico di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($medico) 
    {
        $valoriAttributi ="'" . $this->trimEscapeStringa($medico->getCodiceFiscaleMedico()) . "', '"
                .$this->trimEscapeStringa($medico->getNomeMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getCognomeMedico()) . "', '"  
                . $this->trimEscapeStringa($medico->getViaMedico()) . "', '"
                . $medico->getNumCivicoMedico() . "', '" 
                . $this->trimEscapeStringa($medico->getCAPMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getUsername()) . "', '"             
                . $this->trimEscapeStringa($medico->getProvinciaAlboMedico()) . "', '" 
//                . $this->trimEscapeStringa($medico->getNumIscrizioneMedico()) . "', "
                . $medico->getNumIscrizioneMedico() . "', ";
                if ($medico->getValidatoMedico()===TRUE)
                {
                    $valoriAttributi = $valoriAttributi . $medico->getValidatoMedico();
                }
                else
                {
                     $valoriAttributi = $valoriAttributi .  "FALSE";
                }
               
                
        return $valoriAttributi;
    }
    
    
    
    /**
     * Metodo che permette di conoscere quali sono i pazienti di un medico
     * 
     * @access public
     * @param string $usernameMedico L'username del medico
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return type Description
     */
    public function cercaPazienti($usernameMedico) 
    {
        $query1=  "SELECT utente.Nome, utente.Cognome, utente.Via, utente.NumCivico, utente.CAP, utente.CodFiscale "
                . "FROM utente, medico "
                . "WHERE codFiscaleMedico=medico.codFiscale AND medico.Username='" . $usernameMedico . "'";
        $query2 = "SELECT appuser.Email, utente.CodFiscale "
                . "FROM utente, appuser "
                . "WHERE utente.Username=appuser.Username";
        $query =  "SELECT DISTINCT * "
                . "FROM (" . $query1 .")t1 "
                . "INNER JOIN (" . $query2 . ")t2 "
                . "ON t1.CodFiscale=t2.CodFiscale";

        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
    
    
    /**
     * Metodo che consente di trovare un medico passando come parametro lo username
     * 
     * @access public
     * @param string $username Username del medico da cercare
     * @return array|boolean Un array contenente gli attributi del medico cercato
     */
    public function cercaMedico($username)
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE appuser.Username='" . $username . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username";
//        return $this->eseguiQuery($query);    
        $risultato = $this->eseguiQuery($query);
        return $risultato;
        
    }
    
    
    /**
     * Metodo che consente di cercare un medico passando alla funzione solo il 
     * codice fiscale
     * 
     * @access public
     * @param string $cf Il codice fiscale del medico da cercare
     * @return array|boolean Array contenente gli attributi del medico cercato
     */
    public function cercaMedicoByCF($cf) 
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE " . $this->_nomeTabella. ".codFiscale='" . $cf . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username";
        return $this->eseguiQuery($query);

    }
    
    /**
     * Metodo che consente di cercare un medico passando alla funzione solo la PEC 
     * 
     * @access public
     * @param string $PEC La PEC del medico da cercare
     * @return array|boolean Array contenente gli attributi del medico cercato
     */
    public function cercaMedicoByPEC($PEC) 
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE " . $this->_nomeTabella. ".PEC='" . $PEC . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che permette di modificare via, numero civico e CAP di un medico nel DB
     * 
     * @access public
     * @param string $codFiscale Il codice fiscale dell'utente il cui indirizzo deve essere modificato
     * @param string $via la nuova via
     * @param int $numeroCivico  il numero civico da modificare
     * @param string $CAP Il CAP modificare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function modificaIndirizzoCAP($codFiscale, $via, $numeroCivico,  $CAP) 
    {
        $via = $this->trimEscapeStringa($via);
        $CAP = $this->trimEscapeStringa($CAP);
        $query = "UPDATE " . $this->_nomeTabella . " SET Via='" . $via . "', "
                . "NumCivico='" . $numeroCivico . "', CAP='" . $CAP . "' "
                . "WHERE CodFiscale='" . $codFiscale . "'";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che permette di modificare la provincia dell'albo in cui è 
     * iscritto il medico e il numero d'iscrizione all'albo  nel DB
     * 
     * @access public
     * @param string $codFiscale Il codice fiscale del medico 
     * @param string $provincia La nuova provincia
     * @param int $numIscrizione  Il nuovo numero d'iscrizione 
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function modificaProvAlboENumIscrizione($codiceFiscaleMedico, $provincia, $numIscrizione){
        $provincia = $this->trimEscapeStringa($provincia);
        $query = "UPDATE " . $this->_nomeTabella . " SET ProvinciaAlbo='" . $provincia . "', "
                . "NumIscrizione=" . $numIscrizione . " "
                . "WHERE CodFiscale='" . $codiceFiscaleMedico . "'";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di modificare gli attributi del medico
     * 
     * @access public
     * @param EMedico $medico Il medico da modificare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function modificaMedico($medico) {
        $query1 = "UPDATE " . $this->_nomeTabella . " SET CodFiscale='" . $medico->getCodiceFiscaleMedico() .  "', Nome='"
                . $medico->getNomeMedico() . "', Cognome='" . $medico->getCognomeMedico() . "', Via='" . $medico->getViaMedico() . "', "
                . "NumCivico='" . $medico->getNumCivicoMedico() . "', CAP='" . $medico->getCAPMedico() . "', Username='"
                . $medico->getUsername() . "', ProvinciaAlbo='" . $medico->getProvinciaAlboMedico() . "', NumIscrizione='" 
                . $medico->getNumIscrizioneMedico() . "', Validato=" . $medico->getValidatoMedico() . " WHERE (Username='" . $medico->getUsername() . "') OR (CodFiscale='" . $medico->getCodiceFiscaleMedico() .  "')";

        $query2 = "UPDATE appUser SET Username='" . $medico->getUsername() . "', Password='"
                . $medico->getPassword() . "', Email='" . $medico->getEmail() . "', Bloccato=" . $medico->getBloccato() . ", "
                . "Confermato=" .  $medico->getConfermato() . ", CodiceConferma='" . $medico->getCodiceConferma() . "' "
                .  " WHERE (Username='" . $medico->getUsername() . "') OR (Email='" . $medico->getEmail() .  "')";
       try {
//            // First of all, let's begin a transaction
            $this->_connessione->begin_transaction();

             // A set of queries; if one fails, an exception should be thrown
            $this->eseguiQuery($query2); 
            $this->eseguiQuery($query1);
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
