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
        $this->_attributiTabella = "IdAmministratore, Username, Nome, Cognome, Telefono"; 
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
                . $this->trimEscapeStringa($amministratore->getNomeUtente()) . "', '"
                . $this->trimEscapeStringa($amministratore->getCognomeUtente()) . "', '"
                . $this->trimEscapeStringa($amministratore->getTelefono()) .  "'";
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
             $this->eseguiQuery($query1);
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
                . "FROM appuser," . $this->_nomeTabella . " WHERE (amministratore.Username ='" . $username . "' AND "
                . "appuser.Username=amministratore.Username)";
        return $this->eseguiQuery($query);
    }
    
    public function cercaAppUserNonAmministratori() {
        $queryMultipla = "SELECT appuser.Username, appuser.Email, appuser.TipoUser, CASE WHEN appuser.Bloccato=0 THEN 'NO' ELSE 'SI' END AS Bloccato "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username);"// fine prima query.  //trovo le cliniche
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, CASE WHEN appuser.Bloccato=0 THEN 'NO' ELSE 'SI' END AS Bloccato  "
                . "FROM appuser,medico WHERE (appuser.Username=medico.Username);" // fine seconda query.  //trovo i medici
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, CASE WHEN appuser.Bloccato=0 THEN 'NO' ELSE 'SI' END AS Bloccato  "
                . "FROM appuser,utente WHERE (appuser.Username=utente.Username);"; // fine terza query.  //trovo gli utenti
        
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
    
    public function cercaAppUserBloccati() {
        $queryMultipla = "SELECT appuser.Username, appuser.Email, appuser.TipoUser, clinica.NomeClinica "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username AND "
                . "appuser.Bloccato=TRUE);"// fine prima query.  //trovo le cliniche bloccate
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, medico.Nome, medico.Cognome  "
                . "FROM appuser,medico WHERE (appuser.Username=medico.Username AND "
                . "appuser.Bloccato=TRUE);" // fine seconda query.  //trovo i medici bloccati
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, utente.Nome, utente.Cognome "
                . "FROM appuser,utente WHERE (appuser.Username=utente.Username AND "
                . "appuser.Bloccato=TRUE);"; // fine terza query.  //trovo gli utenti
        
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
    
    public function cercaAppUserDaValidare() {
        $queryMultipla = "SELECT appuser.Username, appuser.Email, appuser.TipoUser, clinica.NomeClinica "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username AND "
                . "clinica.Validato=FALSE);"// fine prima query.  //trovo le cliniche da validare
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, medico.Nome, medico.Cognome  "
                . "FROM appuser,medico WHERE (appuser.Username=medico.Username AND "
                . "medico.Validato=FALSE);"; // fine seconda query.  //trovo i medici da validare
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
    
    public function cercaAppUser($idUser) {
        $queryMultipla = "SELECT appuser.*, clinica.* "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username AND "
                . "appuser.Username='" . $idUser . "');"// fine prima query.  //cerco lo user tra le cliniche
                . "SELECT appuser.*, medico.* "
                . "FROM appuser, medico WHERE (appuser.Username=medico.Username AND "
                . "appuser.Username='" . $idUser . "');" // fine seconda query.  //cerco lo user tra i medici 
                . "SELECT appuser.*, utente.* "
                . "FROM appuser,utente WHERE (appuser.Username=utente.Username AND "
                . "appuser.Username='" . $idUser . "');"; // fine terza query // cerco lo user tra gli utenti
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
    
    /**
     * Metodo che consente di bloccare un account a cui corrisponde l'username passato come parametro
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da bloccare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se l'account è stato bloccato
     */
    public function bloccaUser($username) {
        $query = "UPDATE appuser SET Bloccato=TRUE 
                WHERE Username= '" . $username . "'" ;
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di sbloccare un account a cui corrisponde l'username passato come parametro
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da sbloccare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se l'account è stato sbloccato
     */
    public function sbloccaUser($username) {
        $query = "UPDATE appuser SET Bloccato=FALSE 
                WHERE Username= '" . $username . "'" ;
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di confermare un account a cui corrisponde l'username passato come parametro
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da confermare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se l'account è stato confermato
     */
    final public function amministratoreConfermaUser($username) 
    {
        $query = "UPDATE appuser SET Confermato=TRUE 
                WHERE Username= '" . $username . "'" ;
        return $this->eseguiQuery($query);          
    }
    
    /**
     * Metodo che consente di validare un account a cui corrisponde l'username passato come parametro
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da validare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se l'account è stato validato
     */
    final public function validaUser($username) 
    {
        $query = "UPDATE clinica, medico SET medico.Validato=TRUE, clinica.Validato=TRUE WHERE medico.Username= '" . $username . "' OR clinica.Username= '" . $username . "'";
        return $this->eseguiQuery($query);            
    }
    
    public function eliminaUser($username) {
        $query = "DELETE FROM appUser WHERE appUser.Username= '" . $username . "'";
        return $this->eseguiQuery($query);      
    }
}   


