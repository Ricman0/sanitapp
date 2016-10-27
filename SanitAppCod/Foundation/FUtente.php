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
        $this->_attributiTabella = "Nome, Cognome, CodFiscale, Via, NumCivico, "
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
//        $valoriAttributi = $this->getAttributi($utente) . ", NULL";
        $valoriAttributi = $this->getAttributi($utente);
        $valoriAttributiUser = parent::getAttributi($utente);
        echo $valoriAttributiUser;
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
         
        $query1 = "INSERT INTO appuser (Username, Password, Email, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ", 'utente')";
        $query2 = "INSERT INTO ". $this->_nomeTabella ." ( ". $this->_attributiTabella .") VALUES( ". $valoriAttributi . ")";
        // eseguo le queries
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
//        . $utente->getCodiceFiscaleUtente() . ", " 
//        .   $utente->getEmailUtente() . ", "  . $utente->getUsernameUtente() 
//        . ", " . $utente->getPasswordUtente() ;
        $valoriAttributi = "'" . $this->trimEscapeStringa($utente->getCodiceFiscaleUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getNomeUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getCognomeUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getViaUtente()) . "', "
                . $utente->getNumCivicoUtente() . ", '"
                . $this->trimEscapeStringa($utente->getCAPUtente()) . "', '"
                . $this->trimEscapeStringa($utente->getUsername()) . "','"
                . $this->trimEscapeStringa($utente->getMedicoUtente()) . "'";
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
        
        $query = "SELECT Email FROM utente WHERE utente.Email=" . $email;
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
     * Metodo che consente di trovare un utente passando come parametro l'username
     * dell'utente
     * 
     * @access public
     * @param string $username Username dell'utente da cercare
     * @return array|boolean Un array contenente l'utente cercato 
     */
    public function cercaUtente($username)
    {
        $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE Username='" . $username . "'";
        $risultato = $this->eseguiQuery($query);
        echo "count: ". count($risultato);        
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
        $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE CodFiscale='" . $cf . "'";
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
    
    
    /**
     * 
     */
}
