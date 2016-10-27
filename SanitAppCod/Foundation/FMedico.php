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
                . "CAP, Username, PEC, Validato, ProvinciaAlbo, NumIscrizione";
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
        echo $valoriAttributiUser;
        

       // di default il db è impostato in autocommit
        // per disabilitare l'autocommit solo per alcune istruzioni non eseguire  SET autocommit=0;
        // ma eseguire START TRANSACTION
//        $query = " START TRANSACTION"; "INSERT INTO appUser (Username, Password, Email, Confermato,CodiceConferma,TipoUser) VALUES( " .  $valoriAttributiUser . "'medico')";
//        "INSERT INTO " . $this->_nomeTabella . " ( ". $this->_attributiTabella .") VALUES( " . $valoriAttributi . ")";
//     
//        "COMMIT";
//        
        //oppure
        
        $query1 = "INSERT INTO appuser (Username, Password, Email, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ", 'medico')";
        $query2 = "INSERT INTO medico ( CodFiscale, Nome, Cognome, Via, NumCivico, "
                . "CAP, Username, PEC, Validato, ProvinciaAlbo, NumIscrizione) VALUES( " . $valoriAttributi . ")";
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
                . $this->trimEscapeStringa($medico->getPECMedico()) . "', '" 
                 
                . $this->trimEscapeStringa($medico->getValidatoMedico()) . "', '"
                . $this->trimEscapeStringa($medico->getProvinciaAlboMedico()) . "', '" 
//                . $this->trimEscapeStringa($medico->getNumIscrizioneMedico()) . "', "
                . $medico->getNumIscrizioneMedico() . "'";
               
                
        return $valoriAttributi;
    }
    
    
    
    /**
     * Metodo che permette di conoscere quali sono i pazienti di un medico
     * 
     * @access public
     * @param string $usernameMedico L'username del medico
     * @return type Description
     */
    public function cercaPazienti($usernameMedico) 
    {
        $query =  "SELECT utente.Nome, utente.Cognome, utente.Via, utente.NumCivico, utente.CAP, user.Email, utente.CodFiscale "
                . "FROM utente, medico , user  "
                . "WHERE codFiscaleMedico=medico.codFiscale AND user.Username='" . $usernameMedico . "'";
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
}
