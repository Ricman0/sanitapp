<?php

/**
 * La classe FAmministratore si occupa della gestione della tabella 'amministratore'.
 *
 * @package Foundation
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
        $this->_idTabella = "IdAmministratore";
        $this->_attributiTabella .= "; IdAmministratore, Username, Nome, Cognome, Telefono"; 
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti i valori degli attributi necessari
     * per l'inserimento di un amministratore nel database.
     * 
     * @access public
     * @param EAmministratore $amministratore l'amministratore di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($amministratore) 
    {
        $valoriAttributi = "'" . $amministratore->getIdAmministratoreAmministratore() . "', '" 
                . $this->trimEscapeStringa($amministratore->getUsernameUser()) .  "', '"
                . $this->trimEscapeStringa($amministratore->getNomeAmministratore()) . "', '"
                . $this->trimEscapeStringa($amministratore->getCognomeAmministratore()) . "', '"
                . $this->trimEscapeStringa($amministratore->getTelefonoAmministratore()) .  "'";
        return $valoriAttributi;
    }
    
    /**
     * Metodo per inserire nella tabella amministratore una nuova riga ovvero
     * un nuovo amministratore.
     * 
     * @param EAmministratore $amministratore L'amministratore che si vuole salvare nel DB
     */
    public function inserisciAmministratore($amministratore)
    {         
        
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($amministratore);
        $valoriAttributiUser = parent::getAttributi($amministratore);
        
        $query1 = "INSERT INTO appuser (Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ", 'amministratore')";
        $query2 = "INSERT INTO " . $this->_nomeTabella . " ( ". $this->_attributiTabella . ") VALUES( " . $valoriAttributi . ")";
        try {
            $this->_connessione->begin_transaction();
             $this->eseguiQuery($query1);
             $this->eseguiQuery($query2);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            
        }
    }
    
    /**
     * Metodo che consente di cercare l'amministratore o gli amministratori dell'applicazione.
     * 
     * @access public
     * @param string $username Lo username dell'amministratore da cercare
     * @return array L'amministratore o gli amministratori dell'applicazione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaAmministratore($username=NULL){
        if(isset($username)){
        $query = "SELECT appuser.*, " .  $this->_nomeTabella . ".* "
                . "FROM appuser," . $this->_nomeTabella . " WHERE (amministratore.Username ='" . $username . "' AND "
                . "appuser.Username=amministratore.Username) LOCK IN SHARE MODE";
        }else{
             $query = "SELECT appuser.*, " .  $this->_nomeTabella . ".* "
                . "FROM appuser," . $this->_nomeTabella . " WHERE (appuser.Username=amministratore.Username) "
                     . "LOCK IN SHARE MODE";
        }
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di trovare Username,Email,TipoUser, Bloccato di tutti 
     * gli user di tipo non amministratore dell'applicazione.
     * 
     * @access public
     * @return array|boolean Il risultato della query, FALSE nel caso in cui la query non abbia prodotto risultato.
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUserNonAmministratori() {
        $queryMultipla = "SELECT appuser.Username, appuser.Email, appuser.TipoUser, CASE WHEN appuser.Bloccato=0 THEN 'NO' ELSE 'SI' END AS Bloccato "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username) LOCK IN SHARE MODE;"// fine prima query.  //trovo le cliniche
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, CASE WHEN appuser.Bloccato=0 THEN 'NO' ELSE 'SI' END AS Bloccato  "
                . "FROM appuser,medico WHERE (appuser.Username=medico.Username) LOCK IN SHARE MODE;" // fine seconda query.  //trovo i medici
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, CASE WHEN appuser.Bloccato=0 THEN 'NO' ELSE 'SI' END AS Bloccato  "
                . "FROM appuser,utente WHERE (appuser.Username=utente.Username) LOCK IN SHARE MODE;"; // fine terza query.  //trovo gli utenti
        
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
    
    /**
     * Metodo che consente di cercare gli user bloccati (solo Username,Email,TipoUser,NomeClinica) dell'applicazione.
     * 
     * @access public
     * @return array|boolean Il risultato della query, FALSE nel caso in cui la query non abbia prodotto risultato.
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUserBloccati() {
        $queryMultipla = "SELECT appuser.Username, appuser.Email, appuser.TipoUser, clinica.NomeClinica "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username AND "
                . "appuser.Bloccato=TRUE) LOCK IN SHARE MODE;"// fine prima query.  //trovo le cliniche bloccate
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, medico.Nome, medico.Cognome  "
                . "FROM appuser,medico WHERE (appuser.Username=medico.Username AND "
                . "appuser.Bloccato=TRUE) LOCK IN SHARE MODE;" // fine seconda query.  //trovo i medici bloccati
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, utente.Nome, utente.Cognome "
                . "FROM appuser,utente WHERE (appuser.Username=utente.Username AND "
                . "appuser.Bloccato=TRUE) LOCK IN SHARE MODE;"; // fine terza query.  //trovo gli utenti
        
        return $this->eseguiQueryMultiple($queryMultipla);
    }
    
    /**
     * Metodo che consente di cercare gli user dell'applicazione (solo Username,Email,TipoUser,NomeClinica) che devono essere validati dall'amministratore.
     * 
     * @access public
     * @return array|boolean Il risultato della query, FALSE nel caso in cui la query non abbia prodotto risultato.
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUserDaValidare() {
        $queryMultipla = "SELECT appuser.Username, appuser.Email, appuser.TipoUser, clinica.NomeClinica "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username AND "
                . "clinica.Validato=FALSE) LOCK IN SHARE MODE;"// fine prima query.  //trovo le cliniche da validare
                . "SELECT appuser.Username,appuser.Email, appuser.TipoUser, medico.Nome, medico.Cognome  "
                . "FROM appuser,medico WHERE (appuser.Username=medico.Username AND "
                . "medico.Validato=FALSE) LOCK IN SHARE MODE;"; // fine seconda query.  //trovo i medici da validare
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
    
    /**
     * Metodo che consente di cercare un user tra gli user dell'applicazione.
     * 
     * @access public
     * @param string $idUser L'username dell'user da cercare
     * @return array|boolean Il risultato della query, FALSE nel caso in cui la query non abbia prodotto risultato.
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUser($idUser) {
        $queryMultipla = "SELECT appuser.*, clinica.* "
                . "FROM appuser, clinica WHERE (appuser.Username=clinica.Username AND "
                . "appuser.Username='" . $idUser . "') LOCK IN SHARE MODE;"// fine prima query.  //cerco lo user tra le cliniche
                . "SELECT appuser.*, medico.* "
                . "FROM appuser, medico WHERE (appuser.Username=medico.Username AND "
                . "appuser.Username='" . $idUser . "') LOCK IN SHARE MODE;" // fine seconda query.  //cerco lo user tra i medici 
                . "SELECT appuser.*, utente.* "
                . "FROM appuser,utente WHERE (appuser.Username=utente.Username AND "
                . "appuser.Username='" . $idUser . "') LOCK IN SHARE MODE;"; // fine terza query // cerco lo user tra gli utenti
        $risultato = $this->eseguiQueryMultiple($queryMultipla);
        return $risultato;
    }
    
    /**
     * Metodo che consente di bloccare un account a cui corrisponde l'username passato come parametro.
     * 
     * @access public
     * @param string $username L'username dell'account da bloccare
     * @return boolean TRUE se l'account è stato bloccato
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function bloccaUser($username) {
        
        $queryLock1 = "SELECT * FROM appUser " . 
                " WHERE  (Username='" . $username . "')  FOR UPDATE" ;
        
        $query = "UPDATE appuser SET Bloccato=TRUE 
                WHERE Username= '" . $username . "'" ;
        try {
//            // First of all, let's begin a transaction
           $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock1);
            // A set of queries; if one fails, an exception should be thrown
            $this->eseguiQuery($query);
             

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
    
    /**
     * Metodo che consente di sbloccare un account a cui corrisponde l'username passato come parametro.
     * 
     * @access public
     * @param string $username L'username dell'account da sbloccare
     * @return boolean TRUE se l'account è stato sbloccato
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function sbloccaUser($username) {
        $queryLock1 = "SELECT * FROM appUser " . 
                " WHERE  (Username='" . $username . "')  FOR UPDATE" ;
        $query = "UPDATE appuser SET Bloccato=FALSE 
                WHERE Username= '" . $username . "'" ;
        try {
           $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock1);
            $this->eseguiQuery($query);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }
    }
    
    /**
     * Metodo che consente di confermare un account a cui corrisponde l'username passato come parametro.
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da confermare
     * @return boolean TRUE se l'account è stato confermato
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    final public function amministratoreConfermaUser($username) 
    {
        $queryLock1 = "SELECT * FROM appUser " . 
                " WHERE  (Username='" . $username . "')  FOR UPDATE" ;
        $query = "UPDATE appuser SET Confermato=TRUE 
                WHERE Username= '" . $username . "'" ;
        try {
           $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock1);
            $this->eseguiQuery($query);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }          
    }
    
    /**
     * Metodo che consente di validare un account a cui corrisponde l'username passato come parametro.
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da validare
     * @return boolean TRUE se l'account è stato validato
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    final public function validaUser($username) 
    {
        $queryLock1 = "SELECT * FROM clinica, medico " . 
                " WHERE medico.Username= '" . $username . "' OR clinica.Username= '" . $username . "'  FOR UPDATE" ;
        $query = "UPDATE clinica, medico SET medico.Validato=TRUE, clinica.Validato=TRUE WHERE medico.Username= '" . $username . "' OR clinica.Username= '" . $username . "'";
        try {
           $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock1);
            $this->eseguiQuery($query);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }           
    }
    
    /**
     * Metodo che consente di eliminare un account a cui corrisponde l'username passato come parametro.
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da eliminare
     * @return boolean TRUE se l'account è stato eliminato
     * 
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function eliminaUser($username) {
        
        $queryLock1 = "SELECT * FROM appUser " . 
                " WHERE  (Username='" . $username . "')  FOR UPDATE" ;
        $query = "DELETE FROM appUser WHERE appUser.Username= '" . $username . "'";
        try {
           $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock1);
            $this->eseguiQuery($query);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }
    }  
  
}   


