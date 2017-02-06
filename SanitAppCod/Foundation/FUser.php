<?php

/**
 * La classe FUser si occupa della gestione della tabella 'appUser'.
 *
 * @package Foundation
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
        $this->_nomeColonnaPKTabella = "Username";
        $this->_attributiTabella = "Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser";
    }
  
    /** 
     * Metodo che consente di ottenere in una stringa tutti i valori degli attibuti necessari
     * per l'inserimento di un user nel database.
     * 
     * @access public
     * @param FUser $user L'user di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($user) 
    {
        $valoriAttributi ="'" . $this->trimEscapeStringa($user->getUsernameUser()) . "', '" 
                . $this->trimEscapeStringa($user->getPasswordUser()) . "', '"
                . $this->trimEscapeStringa($user->getEmailUser()) . "', " ;
        if ($user->getPECUser()!== NULL)
                {
                    $valoriAttributi = $valoriAttributi . "'" . $user->getPECUser() . "', ";
                }
                else
                {
                     $valoriAttributi = $valoriAttributi .  "NULL, ";
                }       
        if ($user->getBloccatoUser()===TRUE)
        {
            $valoriAttributi = $valoriAttributi . $user->getBloccatoUser() . ", ";
        }
        else
        {
             $valoriAttributi = $valoriAttributi .  "FALSE, ";
        }
        if ($user->getConfermatoUser()===TRUE)
        {
            $valoriAttributi = $valoriAttributi . $user->getConfermatoUser() . ", '";
        }
        else
        {
             $valoriAttributi = $valoriAttributi .  "FALSE, '";
        }
        $valoriAttributi = $valoriAttributi . $this->trimEscapeStringa($user->getCodiceConfermaUser()) . "', '"
                . $user->getTipoUserUser() . "'" ;
        return $valoriAttributi;
        
        
    }
    
    /**
     * Metodo che consente di cercare uno user in base alla passaword e allo username.
     * 
     * @access public
     * @param string $username L'username dell'user
     * @param string $password La password dell'user
     * @return array Se la query è stata eseguita con successo
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaUserByUsernamePassword($username,$password)
    {
        $username = $this->trimEscapeStringa($username);
        $password = $this->trimEscapeStringa($password);
        $query = "SELECT appuser.*, "
                . "MATCH (Password) AGAINST ('$password ' IN BOOLEAN MODE) "
                . "FROM appuser WHERE Username='" . $username . "' "
                . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) LOCK IN SHARE MODE"; 
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che consente di trovare un user usando congiuntamente l'username e il codice di conferma dell'account.
     * 
     * @access public
     * @param string $username L'username da cercare
     * @param string $codiceConferma Il codice conferma da cercare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return array Array il risultato della query 
     */
//    public function cercaUserByUsernameCodiceConferma ($username,$codiceConferma)
//    {
//        $username = $this->trimEscapeStringa($username);
//        $codiceConferma = $this->trimEscapeStringa($codiceConferma);
//        $query = "SELECT appuser.* "
//                . "FROM appuser WHERE Username='" . $username . "' "
//                . "AND CodiceConferma='" . $codiceConferma . "' LOCK IN SHARE MODE"; 
//        return $this->eseguiQuery($query);
//    }
    
     /**
     * Metodo che consente di trovare un user usando lo username.
     * 
     * @access public
     * @param string $username L'username da cercare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return array Array il risultato della query 
     */
//    public function cercaUserByUsername ($username)
//    {
//        $username = $this->trimEscapeStringa($username);
//        $query = "SELECT appuser.* "
//                . "FROM appuser WHERE Username='" . $username . "' "
//                . "LOCK IN SHARE MODE"; 
//        return $this->eseguiQuery($query);
//    }
    
    
    
    /**
     * Metodo che consente di verificare se l'user (identificato tramite la coppia username e password) esiste nel DB.
     * 
     * @access public
     * @param string $username L'username dell'user
     * @param string $password La password dell'user
     * @return array|boolean Array contenente un solo elemento(l'user cercato), FALSE altrimenti
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function esisteUserDB($username, $password) 
    {
        $username = $this->trimEscapeStringa($username);
        $password = $this->trimEscapeStringa($password);
        $query = "SELECT Username, TipoUser, Confermato, "
                . "MATCH (Password) AGAINST ('$password ' IN BOOLEAN MODE) "
                . "FROM appuser WHERE Username='" . $username . "' "
                . "AND MATCH (Password) AGAINST ('$password' IN BOOLEAN MODE) LOCK IN SHARE MODE"; 
        $risultato = $this->eseguiQuery($query);

        if(is_array($risultato) && count($risultato)===1)
        {
            return $risultato;
        }
        return FALSE;
    }
    
    /**
     * Metodo che consente di controllare se esiste un username.
     * 
     * @access public
     * @param string $username L'username da cercare
     * @return boolean TRUE se esiste l'username, FALSE altrimenti
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function esisteUsernameDB($username)
    {
        $esiste=FALSE;
        $query = "SELECT Username FROM appuser WHERE Username='" . $username . "' LOCK IN SHARE MODE";
        if(count($this->eseguiQuery($query))>0)
        {
            $esiste = TRUE;
        }
        return $esiste;
    }
    
    /**
     * Metodo che permette di controllare se un'email passata per parametro sia
     * già esistente nella tabella user.
     * 
     * @access public
     * @param string $email L'email da controllare
     * @return boolean TRUE se esiste già un'email uguale a quella passata nel 
     * parametro, FALSE altrimenti.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function ricercaEmail($email)
    {
        
        $query = "SELECT Email FROM appuser WHERE Email='" . $email . "' LOCK IN SHARE MODE";
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
     * Metodo che consente di impostare una nuova password.
     * 
     * @param string $username L'username la cui password deve essere modificata
     * @param string $password La nuova password
     * @return type Description
     */
//    public function modificaPassword($username,$password) 
//    {
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
//                " WHERE Username='" . $username . "' FOR UPDATE" ;
//        $query = "UPDATE " . $this->_nomeTabella . " SET Password='" . $password . "' "
//                . "WHERE Username='" . $username . "'";
//        try {
//            $this->_connessione->begin_transaction();
//            $this->eseguiQuery($queryLock); 
//            $this->eseguiQuery($query);
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        }
//    }
    
    /**
     * Metodo che consente di cercare un user attraverso l'email
     * 
     * @final
     * @access public
     * @param string $email L'email dell'user da cercare
     * @return Array Lo user trovato
     */
//    final public function cercaUserByEmail($email) 
//    {
//        $query = "SELECT * FROM appuser WHERE Email='" . $email . "' LOCK IN SHARE MODE";
//        return $this->eseguiQuery($query);
//    }
   
    
    /**
     * Metodo che consente di conferma un account a cui corrisponde l'username passato come parametro
     * 
     * @final
     * @access public
     * @param string $username L'username dell'account da confermare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se l'account è stato confermato
     */
//    final public function confermaUser($username) 
//    {
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
//                " WHERE Username='" . $username . "' FOR UPDATE" ;
//        $query = "UPDATE appuser SET Confermato=TRUE 
//                WHERE Username= '" . $username . "'" ;
//        try {
//            $this->_connessione->begin_transaction();
//            $this->eseguiQuery($queryLock); 
//            $this->eseguiQuery($query);
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        }
//               
//    }
    
}
