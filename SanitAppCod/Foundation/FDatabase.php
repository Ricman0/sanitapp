<?php

/**
 *  La classe  FDatabase si occupa dell'interazione con il database.
 * 
 * @package Foundation
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FDatabase {
    
    /*
     * Attributi della classe FDatabase
     */
    
    /**
     * @access protected
     * @var mixed $_connessione contiene la variabile per la connessione al database. 
     *                          Se la connessione è andata a buon fine 
     *                          conterrà un oggetto mysqli/una risorsa 
     *                          altrimenti varrà false.
     */
    protected $_connessione; 
    
    /**
     * @access protected
     * @var array|boolena $_result contiene il risultato della query
     */
    protected $_result = array();


    /**
     * @access protected
     * @var string $_nomeTabella contiene il nome della tabella con cui si interagisce
     */
    protected $_nomeTabella; 
    
    /**
     * @access protected
     * @var string $_attributiTabella contiene la concatenazione degli attibuti
     *                                della tabella con cui si interagisce
     */
    protected static $_attributiTabella;
//    protected $_attributiTabella;
    
    /**
     * @access protected
     * @var string $_nomeColonnaPKTabella contiene la chiave primaria della tabella
     */
    protected $_nomeColonnaPKTabella;
    
    /**
     * Costruttore della classe FDatabase
     * 
     * @access public
     */
    public function __construct()
    {
        //se non esiste creo un'istanza della classe config (di config.php)
        $config = USingleton::getInstance('Config'); 
        //$dbConfig è un'array in cui memorizzo il necessario per poter
        //effettuare la connessione con il database
        $dbConfig = $config->getDBConfig();
        $this->connessioneDB($dbConfig['host'], $dbConfig['username'], 
                             $dbConfig['password'], $dbConfig['dbname']);   
    }
    
    /**
     * Metodo che permette di ottenere il nome della tabella.
     * 
     * @access public
     * @return string Il nome della tabella
     */
    public function getNomeTabella() 
    {
        return $this->_nomeTabella;
    }
    
    /**
     * Metodo che permette di ottenere la chiave della tabella.
     * 
     * @access public
     * @return string La chiave della tabella
     */
    public function getNomeColonnaPKTabella() 
    {
        return $this->_nomeColonnaPKTabella;
    }
    
    /**
     * Metodo che permette di ottenere gli attributi della tabella.
     * 
     * @access public
     * @return string Gli attributi della tabella
     */
    public function getAttributiTabella() 
    {
        return $this->_attributiTabella;
    }
    
    
    /**
     * Metodo per consente di connettersi ad un database server.
     * 
     * @final
     * @access public
     * @param string $hostname Il nome dell'host o l'indirizzo IP del server (in locale sarà localhost)
     *                         al quale si desidera connettersi(dove sta girando MySQL)                 
     * @param string $username Il nome utente dell'utente (che si utilizzerà) 
     *                         dell'utilizzatore abilitato ad inviare istruzioni
     *                         al DBMS sulla base dei permessi accordati 
     * @param string $password La password dell'utente che si utilizzerà
     * @param string $database Il nome del database su cui si eseguiranno le 
     *                         operazioni
     * @return boolean Ritorna true se è stata stabilita una connessione, 
     *                 false se non è stata stabilita una connessione
     */
    final public function connessioneDB($hostname, $username, $password, $database)
    {
        // memorizzo la resource della connessione in $_connessione
        $this->_connessione = new mysqli($hostname, $username, $password, $database);
        //mysqli_connect_errno() restituisce 0 quando non vi sono errori
        //durante la connessione o un codice di errore quando sorge un problema
        //ho cambiato la if: if(mysqli_connect_errno()!=0) sostituita con 
        if ($this->_connessione->connect_errno != 0)
        { 
            //mysqli_connect_error() usato per acquisire il messaggio di testo di errore
            $messaggioErrore = $this->_connessione->connect_error;
            die('Errore di connessione ('.mysqli_connect_errno().')'.$messaggioErrore);
           
            //oppure 
            // echo 'Errore di connessione ('.$this->_connessione->connect_errno.')'.$messaggioErrore;
            //return false; 
        }
        else
        {
//            echo 'Connessione stabilita ' . $this->_connessione->host_info . "\n";
            //imposto il set di caratteri utf8 per la connessione
            $this->_connessione->query("SET NAMES 'utf8'");
            return true; 
        }
        /*
         * vorrei inserire una variabile booleana $connessioneStabilita che 
         * di default ha valore false, per fare una sola istruzione di return 
         * all'esterno dell'if-else. nel ramo if verrà rimpostato a false,
         * mentre in quello else verrà impostato a true.
         */             
    }

    /**
     * Metodo che permette di cancellare i separatori iniziali e finali (trim)
     * e di effettuare l'escape dei caratteri speciali di una stringa.
     * 
     * @final
     * @access public
     * @param string $stringa La stringa di cui si vuole effettuare l'escape e il trim
     * @return string La stringa di cui si è fatto l'escape e il trim
     */
    final public function trimEscapeStringa($stringa) 
    {
        //trim per cancellare i separatori iniziali e finali
        return $this->_connessione->real_escape_string(trim($stringa));
    }
 
    
    /**
     * Metodo che consente di eseguire una query. 
     * 
     * @final
     * @access public
     * @param string $query La query da eseguire
     * @return array|boolean Il risultato della query.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    final public function eseguiQuery($query) 
    {
        $this->_result = array();  //  è già stato inizializzata così, ma non lo eliminino perchè ne ho bisogno per essere sicuri che in questa variabile ci sia solo il risultato della query che si effettuerà e non quelle precedenti
        // eseguo la query e salvo il risultato in $queryResult
        $queryResult = $this->_connessione->query($query);
        // se il risultato della query è false
        if(!$queryResult)
            {
                throw new XDBException("Errore mysql durante l'esecuzione della query: " . $this->_connessione->error);
            }
        else
            {
                if($queryResult === TRUE)
                {
                   $this->_result = TRUE;
                }
                else 
                {
                    /* una volta che si è sicuri che in $queryResult è contenuto il
                     * risultato della query, si può usare tale variabile per 
                     * estrarre i dati una alla volta usando il metodo fetch_assoc
                     * dell'oggetto.
                     * la funzione fetch_assoc() ritorna la riga successiva
                     */
                    while ($row =$queryResult->fetch_assoc())
                    {
                        $this->_result[] = $row;                       
                    }
                    // si libera la memoria associato a quel risultato
                    $queryResult->free();
                    
                }                
                
                return $this->_result;
            }
        
    }

    /**
     * Metodo che consente di eseguire più query contemporaneamente.
     * 
     * @final
     * @access public
     * @param string $query Le query da eseguire
     * @return array|boolean Il risultato della query, FALSE nel caso in cui la query non abbia prodotto risultato
     * @throws XDBException 
     */
    final public function eseguiQueryMultiple($query)
    {
        $this->_result = array(); //  è già stato inizializzata così, ma non lo eliminino perchè ne ho bisogno per essere sicuri che in questa variabile ci sia solo il risultato della query che si effettuerà e non quelle precedenti
//        // eseguo la query e salvo il risultato in $multiQueryResult
//        $multiQueryResult = $this->_connessione->multi_query($query); 
        $this->_connessione->multi_query($query);
        //cicla fino a quando c'è un risultato successivo della multi query
        do
            {
                /*
                 * la funzione store_result() ritorna l'oggetto risultato 
                 * oppure FALSE. False può significare che c'è stato un errore
                 * (allora in questo caso la stringa error non sarà vuota) oppure
                 * che la query non prodotto alcun risultato.
                 */
                $queryResult = $this->_connessione->store_result();
                
                if ($queryResult === FALSE) //o c'è stato un errore o la query non ritorna un risultato
                {
                    
                    if(empty($this->_connessione->error))
                    {
                        $this->_result = FALSE;
                    }
                    else
                    {
                        throw new XDBException("Errore mysql durante l'esecuzione della query: " . $this->_connessione->error);
                    }
                }
                else 
                {
                    //la query ha prodotto un risultato che deve essere catturato
                         // dal momento che o nessuna delle query o solo una delle tre 
                        // avrà un solo risultato, non inserisco un ciclo 
                        // all'interno di questo ciclo
                    while ($row = $queryResult->fetch_assoc()) 
                    {
                        //memorizzo la riga del risultato  nell'array _result[]
                        $this->_result[] = $row;
                    }
                    // si libera la memoria associato a quel risultato
                    $queryResult->free();
                }
            }while($this->_connessione->next_result());
            return $this->_result;
            
        }
    
    
    /**
     * Metodo per chiudere la connessione con il database.
     * 
     * @final
     * @access public
     */
    final public function terminaConnessioneDB()
    {
        //clean up, chiusura della connessione 
        $this->_connessione->close();
    }
    
    /**
     * Metodo che permette di trovare l'user (utente, medico, clinica, amministratore) che ha
     * un determinato username.
     * 
     * @final
     * @access public
     * @param string $username Username dell'utente da cercare
     * @return array  Array contenente l'user cercato
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    final public function cercaUser($username) 
    {
        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE Username='" . $username."' LOCK IN SHARE MODE";
        
        $query = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE Username='" . $username."'"; 
        return $this->eseguiQuery($query);
        
    }
    
    /**
     * Metodo che consente di ottenere in un'unica stringa tutti i valori degli attributi necessari
     * per l'inserimento di un elemento nel database.
     * 
     * @access public
     * @param object $oggetto L'oggetto che si vuole aggiungere
     * @param string $attributiTabella Il nome degli attributi della tabella, in cui si vuole inserire l'elemento, separati da virgole
     * @param string $nomeClasse Il nome della classe a cui corrisponde la tabella (Senza F o E)
     * @return string La stringa contenente tutti i valori degli attributi
     */
    public function getValoriAttributi($oggetto, $attributiTabella, $nomeClasse = '') 
    {
//        $nomeClasse = 'F' . $nomeClasse;
//        $attributiTabella = explode(',', $this->_attributiTabella);
//        $x ='F' . $nomeClasse;
//        $attributiTabella = explode(',',$x::getNomeAttributi() );
        $attributiTabella = explode(',', $attributiTabella);
        $valoriAttributi = NULL;
        foreach ($attributiTabella as $valore) {
            $valore = trim($valore);
            $funzione = 'get'.$valore.$nomeClasse ;  
            $valoreAttributo = $oggetto->$funzione();
            switch (gettype($valoreAttributo)) {
                case 'string':
                case 'blob':
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", '" . $this->trimEscapeStringa($valoreAttributo) . "'";
                    }
                    else
                    {
                        $valoriAttributi .= "'" . $this->trimEscapeStringa($valoreAttributo)  . "'";
                    }
                    break;

                case 'NULL':
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", NULL ";
                    }
                    else
                    {
                        $valoriAttributi .= "NULL";
                    }
                    break;

                case 'double':
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", '" . $valoreAttributo . "'";
                    }
                    else
                    {
                        $valoriAttributi .= "'" . $valoreAttributo  . "'";
                    }
                    break;

                case 'boolean':
                    if($valoreAttributo === TRUE)
                    {
                        if (isset($valoriAttributi))
                        {
                            $valoriAttributi .= ", " . $valoreAttributo . "";
                        }
                        else
                        {
                            $valoriAttributi .=  $valoreAttributo  ;
                        }
                    }
                    else
                    {
                        if (isset($valoriAttributi))
                        {
                            $valoriAttributi .= ", FALSE";
                        }
                        else
                        {
                            $valoriAttributi .= "FALSE";
                        }
                    }

                    break;

                default:
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", " . $valoreAttributo ;
                    }
                    else
                    {
                        $valoriAttributi .=  $valoreAttributo;
                    }
                    break;
                }
        }
        return $valoriAttributi;
    }

    /**
     * Metodo che permette di aggiungere un oggetto nel DB.
     * 
     * @access public
     * @param object $oggetto L'oggetto che si vuole aggiungere 
     * @return boolean Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function inserisci($oggetto) 
    {
        $nomeClasse = substr((get_class($oggetto)), 1);
        $nomeClassePadre = get_parent_class($oggetto); 
        if(($nomeClassePadre==='EUser'))
        {
            $nomeClassePadre =  substr($nomeClassePadre,1);
            $attributiPadreFiglio = $this->getAttributiTabella();
            $attributi = explode(';', $attributiPadreFiglio);
            $attributiPadre = $attributi[0];
            $attributiFiglio = $attributi[1];
            $valoriAttributiPadre = $this->getValoriAttributi($oggetto, $attributiPadre , $nomeClassePadre);
            $nomeClassePadre = strtolower($nomeClassePadre);
            if($nomeClassePadre ==='user')
            {
                $nomeClassePadre = 'appuser';
            }
            $query1 = "INSERT INTO " . $nomeClassePadre . "(" . $attributiPadre . ") VALUES( " . $valoriAttributiPadre . ")";
            $valoriAttributi = $this->getValoriAttributi($oggetto, $attributiFiglio, $nomeClasse);
            $nomeClasse  = strtolower($nomeClasse);
            $query2 = "INSERT INTO " . $nomeClasse . "(" . $attributiFiglio . ") VALUES( " .  $valoriAttributi . ")";
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
//                print_r($e->getMessage());
                throw new XDBException("Inserimento fallito, contattare l'amministratore.");
            }
        }
        else
        {
            $attributiTabella =  $this->getAttributiTabella();
            $query = "INSERT INTO " . $nomeClasse . "(" . $attributiTabella . ") VALUES( " .  $this->getValoriAttributi($oggetto, $attributiTabella, $nomeClasse ) . ")";
            return $this->eseguiQuery($query); 
        }
    }

    /**
     * Elimina una riga della tabella dal DB.
     * 
     * @access public
     * @param string $id L'id che identifica la riga da eliminare
     * @return boolean TRUE se la query è eseguito con successo, altrimenti lancia eccezione
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function elimina($id) {
        
        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
                " WHERE (" . $this->getNomeColonnaPKTabella() . "='" . $id . "') FOR UPDATE " ;
        if($this->_nomeTabella === 'esame')
        {
            $query = "UPDATE " . $this->_nomeTabella . " SET Eliminato=TRUE "
                . "WHERE (" . $this->getNomeColonnaPKTabella() . "='" . $id. "')";
        }
        else
        {
            $query = "DELETE FROM " . $this->_nomeTabella . " WHERE (" . $this->getNomeColonnaPKTabella() . "='" . $id . "') ";
        }

//        //elimino referto??
        
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
            throw new XDBException("Errore durante l'eliminazione" );
        }
        
    }
    
    /**
     * Metodo che consente di modificare un elemento di una tabella nel DB.
     * 
     * @access public
     * @param string $id L'id dell'elemento da modificare 
     * @param Array $daModificare array associativo il cui indice è il campo della tabella da modificare , il valore è il valore modificato
     * @return boolean TRUE se la query viene eseguito con successo altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function update($id, $daModificare ) {
     
        $queryLock = "SELECT * FROM " . $this->_nomeTabella .
            " WHERE (" . $this->_nomeColonnaPKTabella . "='" . $id . "') FOR UPDATE " ;
        
        $setQuery  = ' SET ';
        
        foreach ($daModificare as $attributo => $valore) {
            if(gettype($valore)==='string')
                {
                    $valore = $this->trimEscapeStringa($valore);
                }
            if($setQuery === ' SET ')
            {
                $setQuery .= $attributo . "='" . $valore . "' ";
            }
            else
            {
                $setQuery .=  ", " . $attributo . "='" . $valore . "' ";
            }                
        }
        
        $query = "UPDATE " . $this->_nomeTabella . $setQuery . " WHERE (" . $this->_nomeColonnaPKTabella . "='" . $id . "')";
        
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
     * Metodo che consente di effettuare una ricerca nel DB.
     * 
     * @access public
     * @param array $daCercare Array contenente il nome degli attributi da cambiare e il loro valore
     * @return array Array contenente gli elementi cercati
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cerca($daCercare=NULL) {
        
        $query = 'SELECT * FROM ' .  $this->_nomeTabella ;
        $where = '';
        if(isset($daCercare))
        {
            foreach ($daCercare as $key => $value) {
                if($where === '')
                {
                    $where .= " WHERE " . $key . "='" . $value . "' "; 
                }
                else 
                {
                    $where .= "AND ". $key . "='" . $value . "' "; 
                }
            }
        }
        $query .= $where . " LOCK IN SHARE MODE" ;
        $result = $this->eseguiQuery($query);
        return $result;
        
        // cercaCategorie() FCategoria
        // cercaEsameById($id) FEsame
        // cercaEsamiByCategoria($nomeCategoria)  FEsame
        // cercaPrenotazioneById($id) FPrenotazione
        // cercaReferto($idPrenotazione) freferto
        // cercaUserByEmail($email)  FUser
        // cercaUserByUsername ($username)   FUser
        // cercaUserByUsernameCodiceConferma ($username,$codiceConferma) FUser
        
//        

    }
    
}
