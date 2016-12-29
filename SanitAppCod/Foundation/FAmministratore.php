<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FAmministratore
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FAmministratore extends FUser{
    
    /**
     * Costruttore della classe FAmministratore
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "amministratore";
        $this->_attributiTabella = "IdAmministratore, Username, Telefono, Fax"; 
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di un amministratore nel database
     * 
     * @access public
     * @param EAmministratore $amministratore l'amministratore di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($amministratore) 
    {
        $valoriAttributi = "'" . $amministratore->getID() . "', '" 
                . $this->trimEscapeStringa($amministratore->getUsername()) .  "', '"
                . $amministratore->getTelefono() .  "', '" 
                . $amministratore->getFax() . "'";
        return $valoriAttributi;
    }
    
    /**
     * Metodo per inserire nella tabella amministratore una nuova riga ovvero
     * un nuovo amministratore
     * 
     * @param EAmministratore $amministratore L'oggetto di tipo EAmministratore che si vuole salvare nella
     *                       tabella amministratore
     */
    public function inserisciAmministratore($amministratore)
    {         
        
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($amministratore);
        $valoriAttributiUser = parent::getAttributi($amministratore);
    
        $query1 = "INSERT INTO appuser (Username, Password, Email, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ", 'amministratore')";
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
    
    public function cercaAmministratore($username){
        $query = "SELECT appuser.*, " .  $this->_nomeTabella . ".* "
                . "FROM appuser," . $this->_nomeTabella . " WHERE (Username ='" . $username . "' AND "
                . "appuser.Username=amministratore.Username)";
        return $this->eseguiQuery($query);
    }
    
    public function cercaAppUserNonAmministratori() {
        $queryMultipla = "SELECT appuser.*, clinica.* "
                . "FROM appuser,clinica WHERE (Username ='" . $username . "' AND "
                . "appuser.Username=clinica.Username);"// fine prima query.  //trovo le cliniche
                . "SELECT appuser.*, medico.* "
                . "FROM appuser,medico WHERE (Username ='" . $username . "' AND "
                . "appuser.Username=medico.Username);"
                . "SELECT appuser.*, utente.* "
                . "FROM appuser,utente WHERE (Username ='" . $username . "' AND "
                . "appuser.Username=utente.Username)"; // cerco tra inizio della prenotazione e la fine della prenotazione;
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
}
