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
class FMedico extends FDatabase {
    
    /**
     * Costruttore della classe FMedico
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "medico";
        $this->_attributiTabella = "Nome, Cognome, CodFiscale, Via, NumCivico, "
                . "CAP, Email, Username, Password, PEC, Validato, ProvinciaAlbo, NumIscrizione, Confermato, CodiceConferma";
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
        
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO " . $this->_nomeTabella . " ( ". $this->_attributiTabella .") VALUES( " . $valoriAttributi . ")";
        // eseguo la query
        if ($this->eseguiQuery($query)===TRUE)
        {
            echo " FMedico inseritooo ";
            return TRUE;
        }
        else 
        {
            echo " FMedico non inseritooo ";
            return FALSE;
        }
    }
    
    /** 
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di un medico nel database
     * 
     * @access private
     * @param EMedico $medico Il medico di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    private function getAttributi($medico) 
    {
        $valoriAttributi ="'" . $this->trimEscapeStringa($medico->getNomeMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getCognomeMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getCodiceFiscaleMedico()) . "', '"
                . $this->trimEscapeStringa($medico->getViaMedico()) . "', '"
                . $medico->getNumCivicoMedico() . "', '" 
                . $this->trimEscapeStringa($medico->getCAPMedico()) . "', '"              
                . $this->trimEscapeStringa($medico->getEmailMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getUsernameMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getPasswordMedico()) . "', '"
                . $this->trimEscapeStringa($medico->getPECMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getValidatoMedico()) . "', '"
                . $this->trimEscapeStringa($medico->getProvinciaAlboMedico()) . "', '" 
//                . $this->trimEscapeStringa($medico->getNumIscrizioneMedico()) . "', "
                . $medico->getNumIscrizioneMedico() . "', '"
                . $medico->getConfermatoMedico() . "', '"
                . $this->trimEscapeStringa($medico->getCodiceConfermaMedico()) ."'";
                
        return $valoriAttributi;
    }
    
    /**
     * Metodo che permette di controllare se un'email passata per parametro sia
     * già esistente nella tabella medico
     * 
     * @access public
     * @param string $email L'email da controllare
     * @return boolean TRUE se esiste già un'email uguale a quella passata nel 
     * parametro, FALSE altrimenti.
     */
    public function ricercaEmailMedico($email)
    {
        
        $query = "SELECT Email FROM medico WHERE medico.Email=" . $email;
        $risultato = $this->eseguiQuery($query);
        if ($risultato === FALSE)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
