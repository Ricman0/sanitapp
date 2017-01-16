<?php

/**
 * Description of FUtente
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FUtente extends FUser{
    
    /**
     * Costruttore della classe FUtente
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "utente";
        $this->_attributiTabella .= "; CodFiscale, Nome, Cognome,  Via, NumCivico, "
                . "CAP, Username, CodFiscaleMedico";
    }
    
    
    /**
     * Metodo per inserire nella tabella Utente una nuova riga ovvero
     * un nuovo utente
     * 
     * @param EUtente $utente L'oggetto di tipo EUtente che si vuole salvare nella
     *                       tabella Utente
     * @return Boolean TRUE se l'utente è stato inserito correttamente nel DB, FALSE altrimenti.
     */
    public function inserisciUtente($utente)
    {         
        //recupero i valori contenuti negli attributi
        // aggiungo NULL per il codice fiscale del medico
        $valoriAttributi = $this->getAttributi($utente);
        $valoriAttributiUser = parent::getAttributi($utente);
        
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
         
        $query1 = "INSERT INTO appuser (Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ")";
        $query2 = "INSERT INTO ". $this->_nomeTabella ." ( ". $this->_attributiTabella .") VALUES( ". $valoriAttributi . ")";
        // eseguo le queries
        try {
            // inzia la transazione
            $this->_connessione->begin_transaction();

            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
            $this->eseguiquery($query1);
            $this->eseguiQuery($query2);

            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
            return $this->_connessione->commit();
        } catch (Exception $e) {
            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
            $this->_connessione->rollback();
            throw new XDBException("Inserimento fallito, contattare l'amministratore.");
        }
    }

    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di un utente nel database
     * 
     * @access public
     * @param EUtente $utente L'utente di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi (eccetto prenotazioni) separati da una virgola
     */
    public function getAttributi($utente) 
    {
//        $valoriAttributi = $$utente->getNomeUtente() . ", " . $utente->getCognomeUtente()
//        . ", " . $utente->getViaUtente(). ", " 
//        . $utente->getNumCivicoUtente() . ", " . $utente->getCAPUtente() . ", " 
//        . $utente->getCodFiscaleUtente() . ", " 
//        .   $utente->getEmailUserUtente() . ", "  . $utente->getUsernameUtente() 
//        . ", " . $utente->getPasswordUtente() ;
        $valoriAttributi = "'" . $this->trimEscapeStringa($utente->getCodFiscaleUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getNomeUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getCognomeUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getViaUtente()) . "', "
                . $utente->getNumCivicoUtente() . ", '"
                . $this->trimEscapeStringa($utente->getCAPUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getUsernameUser()) . "', ";
        if(NULL !== $utente->getCodFiscaleMedicoUtente())
        {
            $valoriAttributi = $valoriAttributi . "'" . $utente->getCodFiscaleMedicoUtente() . "'";
        }
        else 
        {
            $valoriAttributi = $valoriAttributi . "NULL "; 
        }     
        return $valoriAttributi;
    }
    
    /**
     * Metodo che permette di controllare se un'email passata per parametro sia
     * già esistente nella tabella utente
     * 
     * @access public
     * @param string $email L'email da controllare
     * @return boolean TRUE se esiste già un'email uguale a quella passata nel 
     * parametro, FALSE altrimenti.
     */
    public function ricercaEmailUtente($email)
    {
        
        $query = "SELECT Email FROM utente WHERE utente.Email=" . $email . " LOCK IN SHARE MODE";
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
    
    /**
     * Metodo che consente di eliminare un utente dal database
     * 
     * @param string $cf Codice fiscale dell'utente da eliminare
     * @return boolean True se l'utente è stato eliminato, False altrimenti
     */
    public function eliminaUtente($cf)
    {
        $query = "DELETE FROM Utente WHERE CodFiscale = ".$cf;
        $eliminato = $this->_connessione->query($query);
        if($eliminato === TRUE)
        {
            echo "Utente eliminato correttamente dal database";
        }
        else 
        {
            echo "Si è verificato un errore durante l'eliminazione" .$this->_connessione->error;
        }
        return $eliminato;
    }
    
    /**
     * Metodo che consente di trovare un utente passando come parametro lo username
     * dell'utente
     * 
     * @access public
     * @param string $username Username dell'utente da cercare
     * @return array|boolean Un array contenente l'utente cercato
     */
    public function cercaUtente($username)
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE appuser.Username='" . $username . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username LOCK IN SHARE MODE";
        $risultato = $this->eseguiQuery($query);    
        return $risultato;
        
    }
    
    /**
     * Metodo che consente di cercare un utente passando alla funzione solo il 
     * codice fiscale
     * 
     * @access public
     * @param string $cf Il codice fiscale dell'utente da cercare
     * @return array|boolean Array contenente l'utente cercato
     */
    public function cercaUtenteByCF($cf) 
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE " . $this->_nomeTabella. ".codFiscale='" . $cf . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username LOCK IN SHARE MODE";
        $risultato = $this->eseguiQuery($query);
//        echo "count: ". count($risultato);        
        return $risultato;
    }
    
    /**
     * Metodo che permette di modificare un attributo di una tupla utente
     * 
     * @param string $attributo Il nome della colonna nella tabella utente 
     *               di cui si vuole modificare il valore del contenuto
     * @param string $valore Il valore con il quale modificare il vecchio valore
     */
    //???
    
    /**
     * Metodo che permette di modificare via, numero civico e CAP di un utente nel DB
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
        
        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE CodFiscale='" . $codFiscale . "' FOR UPDATE" ;
        $via = $this->trimEscapeStringa($via);
        $CAP = $this->trimEscapeStringa($CAP);
        $query = "UPDATE " . $this->_nomeTabella . " SET Via='" . $via . "', "
                . "NumCivico='" . $numeroCivico . "', CAP='" . $CAP . "' "
                . "WHERE CodFiscale='" . $codFiscale . "'";
        
        try {
            // inzia la transazione
            $this->_connessione->begin_transaction();

            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
            $this->eseguiquery($queryLock);
            $this->eseguiQuery($query);

            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
            return $this->_connessione->commit();
        } catch (Exception $e) {
            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
            $this->_connessione->rollback();
            throw new XDBException('errore');
        } 
    }
    
     /**
     * Metodo che permette di modificare il medico curante di un utente nel DB
     * 
     * @access public
     * @param string $codFiscale Il codice fiscale dell'utente il cui medico curante deve essere modificato
     * @param string $codFiscaleMedico Il codice fiscale del nuovo medico
     * @return boolean TRUE se la modifica è andata a buon fine, FALSE altrimenti
     */
    public function modificaMedicoCurante($codFiscale, $codFiscaleMedico) 
    {
        $codFiscaleMedico = $this->trimEscapeStringa($codFiscaleMedico);
        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE CodFiscale='" . $codFiscale . "' FOR UPDATE" ;
        $query = "UPDATE " . $this->_nomeTabella . " SET CodFiscaleMedico='" . $codFiscaleMedico . " ' "
                . "WHERE CodFiscale='" . $codFiscale . "'";
        try {
            // inzia la transazione
            $this->_connessione->begin_transaction();

            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
            $this->eseguiquery($queryLock);
            $this->eseguiQuery($query);

            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
            return $this->_connessione->commit();
        } catch (Exception $e) {
            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
            $this->_connessione->rollback();
            throw new XDBException('errore');
        } 
    }
    
    public function getUtentiNonBloccati() 
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE appuser.Bloccato=FALSE AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di modificare gli attributi dell'utente
     * 
     * @access public
     * @param EUtente $utente L'utente da modificare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function modificaUtente($utente) {
        
        $queryLock1 = "SELECT * FROM " . $this->_nomeTabella .
                " WHERE  (Username='" . $utente->getUsernameUser() . "') OR (CodFiscale='" . $utente->getCodFiscaleUtente() .  "') FOR UPDATE" ;
        $queryLock2 = "SELECT * FROM appUser " . 
                " WHERE  (Username='" . $utente->getUsernameUser() . "') OR (Email='" . $utente->getEmailUser() .  "') FOR UPDATE" ;
        $query1 = "UPDATE " . $this->_nomeTabella . " SET CodFiscale='" . $utente->getCodFiscaleUtente() .  "', Nome='"
                . $utente->getNomeUtente() . "', Cognome='" . $utente->getCognomeUtente() . "', Via='" . $utente->getViaUtente() . "', "
                . "NumCivico='" . $utente->getNumCivicoUtente() . "', CAP='" . $utente->getCAPUtente() . "', Username='"
                . $utente->getUsernameUser() . "' WHERE (Username='" . $utente->getUsernameUser() . "') OR (CodFiscale='" . $utente->getCodFiscaleUtente() .  "')";

        $query2 = "UPDATE appUser SET Username='" . $utente->getUsernameUser() . "', Password='"
                . $utente->getPasswordUser() . "', Email='" . $utente->getEmailUser() . "', Bloccato=" . $utente->getBloccatoUser() . ", "
                . "Confermato=" .  $utente->getConfermatoUser() . ", CodiceConferma='" . $utente->getCodiceConfermaUser() . "' "
                .  " WHERE (Username='" . $utente->getUsernameUser() . "') OR (Email='" . $utente->getEmailUser() .  "')";
       
        try {
//            // First of all, let's begin a transaction
           $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock1);
            $this->eseguiQuery($queryLock2);
            // A set of queries; if one fails, an exception should be thrown
            $this->eseguiQuery($query1);
             
            $this->eseguiQuery($query2);
             

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
