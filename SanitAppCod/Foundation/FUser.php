<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FUser
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FUser extends FDatabase {
    
    /**
     * Costruttore della classe FUser
     * 
     * @access public
     */
    public function __construct() {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "appuser";
        $this->_attributiTabella = "Username, Password, TipoUtente, Email, Confermato, CodiceConferma";
    }
    
    /** 
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di un user nel database
     * 
     * @access public
     * @param FUser $user L'user di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($user) 
    {
        $valoriAttributi ="'" . $this->trimEscapeStringa($user->getUsername()) . "', '" 
                . $this->trimEscapeStringa($user->getEmail()) . "', '" 
                . $this->trimEscapeStringa($user->getPassword()) . "', '"
                . $user->getConfermato() . "', '"
                . $this->trimEscapeStringa($user->getCodiceConferma()) . "'";
        return $valoriAttributi;
    }
    
    /**
     * Metodo che consente di inserire un qualsiasi tipo di user dell'applicazione nel db 
     * 
     * @final
     * @access public
     * @param string $query1 La prima query da eseguire
     * @param string $query2 La seconda query da eseguire
     */
    final public function eseguiTransactionInserisciUser($query1, $query2)
    {
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
    
    
    
    
    /**
     * Metodo per inserire nella tabella User una nuova riga ovvero
     * un nuovo user
     * 
     * @param EUser $user L'oggetto di tipo EUser che si vuole salvare nella
     *                       tabella User
     */
    public function inserisciUser($user)
    {       
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($user);
        
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO " . $this->_nomeTabella . " ( ". $this->_attributiTabella .") VALUES( " . $valoriAttributi . ")";
        // eseguo la query
        if ($this->eseguiQuery($query)===TRUE)
        {
            echo " FUser inseritooo ";
            return TRUE;
        }
        else 
        {
            echo " FUser non inseritooo ";
            return FALSE;
        }
    }
    
    /**
     * Metodo che permette di controllare se un'email passata per parametro sia
     * già esistente nella tabella user
     * 
     * @access public
     * @param string $email L'email da controllare
     * @return boolean TRUE se esiste già un'email uguale a quella passata nel 
     * parametro, FALSE altrimenti.
     */
    public function ricercaEmail($email)
    {
        
        $query = "SELECT Email FROM user WHERE Email=" . $email;
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
