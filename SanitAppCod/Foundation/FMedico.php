<?php

/**
 * La classe FMedico si occupa della gestione della tabella 'medico'. 
 *
 * @package Foundation
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
        $this->_idTabella = "CodFiscale";
        $this->_attributiTabella .= "; CodFiscale, Nome, Cognome, Via, NumCivico, "
                . "CAP, Username, ProvinciaAlbo, NumIscrizione, Validato";
    }
    
    /**
     * Metodo per inserire nella tabella Medico una nuova riga ovvero
     * un nuovo medico.
     * 
     * @access public
     * @param EMedico $medico L'oggetto di tipo EMedico che si vuole salvare nella
     *                       tabella Medico
     */
    public function inserisciMedico($medico)
    {
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($medico);
        $valoriAttributiUser = parent::getAttributi($medico);

        
        $query1 = "INSERT INTO appuser (Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser) VALUES( " .  $valoriAttributiUser . ", 'medico')";
        $query2 = "INSERT INTO medico ( CodFiscale, Nome, Cognome, Via, NumCivico, "
                . "CAP, Username, ProvinciaAlbo, NumIscrizione, Validato) VALUES( " . $valoriAttributi . ")";
       
        try {
            $this->_connessione->begin_transaction();
             $this->eseguiquery($query1);
             $this->eseguiQuery($query2);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
        }
    }
    
    /** 
     * Metodo che consente di ottenere in una stringa tutti i valori degli attibuti necessari
     * per l'inserimento di un medico nel database.
     * 
     * @access public
     * @param EMedico $medico Il medico di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($medico) 
    {
        $valoriAttributi ="'" . $this->trimEscapeStringa($medico->getCodFiscaleMedico()) . "', '"
                .$this->trimEscapeStringa($medico->getNomeMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getCognomeMedico()) . "', '"  
                . $this->trimEscapeStringa($medico->getViaMedico()) . "', '"
                . $medico->getNumCivicoMedico() . "', '" 
                . $this->trimEscapeStringa($medico->getCAPMedico()) . "', '" 
                . $this->trimEscapeStringa($medico->getUsernameUser()) . "', '"             
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
     * Metodo che permette di conoscere quali sono i pazienti di un medico.
     * 
     * @access public
     * @param string $usernameMedico L'username del medico
     * @return array I pazienti del medico se la query è eseguita con successo, altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaPazienti($usernameMedico) 
    {
        $query1=  "SELECT utente.Nome, utente.Cognome, utente.Via, utente.NumCivico, utente.CAP, utente.CodFiscale "
                . "FROM utente, medico "
                . "WHERE codFiscaleMedico=medico.codFiscale AND medico.Username='" . $usernameMedico . "' LOCK IN SHARE MODE";
        $query2 = "SELECT appuser.Email, utente.CodFiscale "
                . "FROM utente, appuser "
                . "WHERE utente.Username=appuser.Username LOCK IN SHARE MODE";
        $query =  "SELECT DISTINCT * "
                . "FROM (" . $query1 .")t1 "
                . "INNER JOIN (" . $query2 . ")t2 "
                . "ON t1.CodFiscale=t2.CodFiscale LOCK IN SHARE MODE";

        return $this->eseguiQuery($query);
    }
    
    
    /**
     * Metodo che consente di trovare un medico passando come parametro lo username.
     * 
     * @access public
     * @param string $username Username del medico da cercare
     * @return array Un array contenente gli attributi del medico cercato, altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo 
     */
    public function cercaMedico($username)
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE appuser.Username='" . $username . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);     
    }
    
    
    /**
     * Metodo che consente di cercare un medico passando alla funzione solo il 
     * codice fiscale.
     * 
     * @access public
     * @param string $cf Il codice fiscale del medico da cercare
     * @return array Array contenente gli attributi del medico cercato, altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo 
     */
    public function cercaMedicoByCF($cf) 
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE " . $this->_nomeTabella. ".codFiscale='" . $cf . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);

    }
    
    /**
     * Metodo che consente di cercare un medico passando alla funzione solo la PEC. 
     * 
     * @access public
     * @param string $PEC La PEC del medico da cercare
     * @return array Array contenente gli attributi del medico cercato
     * @throws XDBException Se la query non è stata eseguita con successo 
     */
    public function cercaMedicoByPEC($PEC) 
    {
        $query = "SELECT appuser.*, " . $this->_nomeTabella . ".* FROM " . $this->_nomeTabella . ",appuser "
                . "WHERE " . $this->_nomeTabella. ".PEC='" . $PEC . "' AND "
                . "appuser.Username=" . $this->_nomeTabella . ".Username LOCK IN SHARE MODE";
        return $this->eseguiQuery($query);
    }
    
    /**
     * Metodo che permette di modificare via, numero civico e CAP di un medico nel DB.
     * 
     * @access public
     * @param string $codFiscale Il codice fiscale dell'utente il cui indirizzo deve essere modificato
     * @param string $via la nuova via
     * @param int $numeroCivico  il numero civico da modificare
     * @param string $CAP Il CAP modificare
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
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
            $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock); 
            $this->eseguiQuery($query);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }
    }
    
    /**
     * Metodo che permette di modificare la provincia dell'albo in cui è 
     * iscritto il medico e il numero d'iscrizione all'albo  nel DB.
     * 
     * @access public
     * @param string $codiceFiscaleMedico Il codice fiscale del medico 
     * @param string $provincia La nuova provincia
     * @param int $numIscrizione  Il nuovo numero d'iscrizione 
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaProvAlboENumIscrizione($codiceFiscaleMedico, $provincia, $numIscrizione){
        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE CodFiscale='" . $codiceFiscaleMedico . "' FOR UPDATE" ;
        $provincia = $this->trimEscapeStringa($provincia);
        $query = "UPDATE " . $this->_nomeTabella . " SET ProvinciaAlbo='" . $provincia . "', "
                . "NumIscrizione=" . $numIscrizione . " "
                . "WHERE CodFiscale='" . $codiceFiscaleMedico . "'";
        try {
            $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock); 
            $this->eseguiQuery($query);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }
    }
    
    /**
     * Metodo che consente di modificare gli attributi del medico.
     * 
     * @access public
     * @param EMedico $medico Il medico da modificare
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaMedico($medico) {
        $queryLock1 = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE (Username='" . $medico->getUsernameUser() . "') OR (CodFiscale='" . $medico->getCodFiscaleMedico() .  "') FOR UPDATE" ;
        $queryLock2 = "SELECT * FROM appUser " 
                ." WHERE (Username='" . $medico->getUsernameUser() . "') OR (Email='" . $medico->getEmailUser() .  "') FOR UPDATE" ;
        $query1 = "UPDATE " . $this->_nomeTabella . " SET CodFiscale='" . $medico->getCodFiscaleMedico() .  "', Nome='"
                . $medico->getNomeMedico() . "', Cognome='" . $medico->getCognomeMedico() . "', Via='" . $medico->getViaMedico() . "', "
                . "NumCivico='" . $medico->getNumCivicoMedico() . "', CAP='" . $medico->getCAPMedico() . "', Username='"
                . $medico->getUsernameUser() . "', ProvinciaAlbo='" . $medico->getProvinciaAlboMedico() . "', NumIscrizione='" 
                . $medico->getNumIscrizioneMedico() . "', Validato=" . $medico->getValidatoMedico() . " WHERE (Username='" . $medico->getUsernameUser() . "') OR (CodFiscale='" . $medico->getCodFiscaleMedico() .  "')";

        $query2 = "UPDATE appUser SET Username='" . $medico->getUsernameUser() . "', Password='"
                . $medico->getPasswordUser() . "', Email='" . $medico->getEmailUser() . "', Bloccato=" . $medico->getBloccatoUser() . ", "
                . "Confermato=" .  $medico->getConfermatoUser() . ", CodiceConferma='" . $medico->getCodiceConfermaUser() . "' "
                .  " WHERE (Username='" . $medico->getUsernameUser() . "') OR (Email='" . $medico->getEmailUser() .  "')";
       try {
            $this->_connessione->begin_transaction();
            $this->eseguiQuery($queryLock1); 
            $this->eseguiQuery($queryLock2);
            $this->eseguiQuery($query2); 
            $this->eseguiQuery($query1);
            return $this->_connessione->commit();
        } catch (Exception $e) {
            $this->_connessione->rollback();
            throw new XDBException('errore');
        }
    }
}
