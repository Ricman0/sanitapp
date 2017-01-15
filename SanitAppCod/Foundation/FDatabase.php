<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FDatabase
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
     * Metodo che permette di ottente il nome della tabella
     * 
     * @access public
     * @return string Il nome della tabella
     */
    public function getNomeTabella() 
    {
        return $this->_nomeTabella;
    }
    
    /**
     * Metodo che permette di ottente gli attributi della tabella
     * 
     * @access public
     * @return string Gli attributi della tabella
     */
    public function getAttributiTabella() 
    {
        return $this->_attributiTabella;
    }
    
    
    /**
     *Metodo per connettersi ad un database server
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
     * Metodo che permette di cancellare i separatori inizialie finali (trim)
     * e di effettuare l'escape dei caratteri speciali di una stringa
     * 
     * @final
     * @access public
     * @param string $stringa La stringa di cui si vuole effettuare l'escape e il trim
     * @return string La stringa di cui si è fatto l'escape
     */
    final public function trimEscapeStringa($stringa) 
    {
        //trim per cancellare i separatori iniziali e finali
//        $stringa = trim($stringa);
//        $stringa = $this->_connessione->real_escape_string($stringa);
//        return $stringa;
        return $this->_connessione->real_escape_string(trim($stringa));
    }
 
    
    /**
     * Metodo che consente di eseguire una query 
     * 
     * @final
     * @access public
     * @param string $query La query da eseguire
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return array|boolean Il risultato della query.
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
     * Metodo che consente di eseguire più query contemporaneamente
     * 
     * @final
     * @access public
     * @param string $query Le query da eseguire
     * @throws XDBException
     * @return array|boolean Il risultato della query, FALSE nel caso in cui la query non abbia prodotto risultato
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
                
                if ($queryResult === FALSE)
                {
                    //o c'è stato un errore o la query non ritorna un risultato
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
     * Metodo per chiudere la connessione con il database
     * 
     * @final
     * @access public
     * @return type Description
     */
    final public function terminaConnessioneDB()
    {
        //clean up, chiusura della connessione
        $this->_connessione->close();
    }
    
    
    /**
     * Metodo che permette di stampare un array ( risultato di una query)
     * 
     * @final
     * @access public
     * @param Array|boolean $risultato Il risultato di una query
     */
    final public function stampaRisultatoQuery($risultato) 
    {
        if(empty($risultato))
        {
           echo " array vuoto" ;
        }
        if(is_array($risultato) === TRUE)
        {
        
        }
        else
        {
            echo($risultato);
            
        } 
    }
    
    /**
     * Metodo che permette di trovare l'utente (utente, medico, clinica) che ha
     * un determinato username
     * 
     * @final
     * @access public
     * @param string $username Username dell'utente da cercare
     * @return Array|boolean  Il risultato della query
     */
    final public function cercaUser($username) 
    {
        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE Username='" . $username."' LOCK IN SHARE MODE";
        
        $query = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE Username='" . $username."'"; 
        return $this->eseguiQuery($query);
        
    }
    
    public static function getValoriAttributi( $oggetto, $nomeClasse = '') 
    {
        $nomeClassePadre = 'F' . $nomeClasse;
//        $attributiTabella = explode(',', $this->_attributiTabella);
        $attributiTabella = explode(',', $nomeClassePadre::getNomeAttributi());
        echo 'attributi';
        print_r($attributiTabella);
        $valoriAttributi = NULL;
        foreach ($attributiTabella as $valore) {
            $valore = trim($valore);
            $funzione = 'get'.$valore.$nomeClasse ;
            $valoreAttributo = parent::$funzione();
//            $valoreAttributo = $oggetto->$funzione();
            switch (gettype($valoreAttributo)) {
                case 'string':
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", '" . $this->trimEscapeStringa($valoreAttributo) . "'";
                    }
                    else
                    {
                        $valoriAttributi = "'" . $this->trimEscapeStringa($valoreAttributo)  . "'";
                    }
                    break;

                case 'NULL':
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", NULL ";
                    }
                    else
                    {
                        $valoriAttributi = "NULL";
                    }
                    break;

                case 'double':
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", '" . $valoreAttributo . "'";
                    }
                    else
                    {
                        $valoriAttributi = "'" . $valoreAttributo  . "'";
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
                            $valoriAttributi = "'" . $valoreAttributo  . "'";
                        }
                    }
                    else
                    {
                        if (isset($valoriAttributi))
                        {
                            $valoriAttributi .= ", 'FALSE'";
                        }
                        else
                        {
                            $valoriAttributi = "FALSE";
                        }
                    }

                    break;

                default:
                    if (isset($valoriAttributi))
                    {
                        $valoriAttributi .= ", " . $valoreAttributo . "";
                    }
                    else
                    {
                        $valoriAttributi = "" . $valoreAttributo . "";
                    }
                    break;
                }
        }
        return $valoriAttributi;
    }
    
    public static function getNomeAttributi() {
        return self::$_attributiTabella;
    }
    
    
    /**
     * Metodo che permette di aggiungere un oggetto nel DB
     * 
     * @access public
     * @param object $oggetto lL'oggetto che si vuole aggiungere 
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     */
    public function inserisci($oggetto) {
        
//        $valoriAttributi = $this->getAttributi($oggetto);
//        $nomeTabella =substr(strtolower(get_class($oggetto)), 1);// nome della classe dell'oggetto in minuscolo eliminando la e iniziale
        $nomeClasse = substr((get_class($oggetto)), 1);
        $nomeClassePadre = get_parent_class($oggetto); 
        if(isset($nomeClassePadre))
        {
//            $nomeClassePadre = strtolower($nomeClassePadre);
//            $nomeClassePadre = 'F' . substr($nomeClassePadre,1);
//            print_r($nomeClassePadre);
//            $attributiPadre = $nomeClassePadre::getNomeAttributi();
//            echo 'attributi padre';
//            print_r($attributiPadre);
//            echo ' niente';
            $nomeClassePadre = 'F' . substr($nomeClassePadre,1);
            $attributiPadre = $nomeClassePadre::getNomeAttributi();
            $valoriAttributiPadre = $nomeClassePadre::getValoriAttributi($oggetto, 'User');
            
            $query1 = "INSERT INTO " . $nomeClassePadre . "(" . $attributiPadre . ") VALUES( " . $valoriAttributiPadre . ")";
            $query2 = "INSERT INTO " . $nomeClasse . "(" . $this->_attributiTabella . ") VALUES( " .  $this->getValoriAttributi($this, 'Clinica') . ")";
             print_r($query1);
            print_r($query2);
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
        else
        {
            $query = "INSERT INTO " . $nomeClasse . "(" . $this->_attributiTabella . ") VALUES( " .  $this->getValoriAttributi() . ")";
            return $this->eseguiQuery($query); 
        }
        
//        if ($nomeClasse === 'Utente' || $nomeClasse === 'Medico' || $nomeClasse === 'Clinica' )
//        {
//            
//            $attributiTabellaPadre = explode(',', parent::$this->_attributiTabella);
//            print_r($attributiTabellaPadre);
//            $valoriAttributiPadre = NULL;
//            foreach ($attributiTabellaPadre as $valore) {
//                $valore = trim($valore);
//                $funzione = 'get'.$valore;
//                $valoreAttributo = $oggetto->$funzione();
//                switch (gettype($valoreAttributo)) {
//                    case 'string':
//                        if (isset($valoriAttributiPadre))
//                        {
//                            $valoriAttributiPadre .= ", '" . $this->trimEscapeStringa($valoreAttributo) . "'";
//                        }
//                        else
//                        {
//                            $valoriAttributiPadre = "'" . $this->trimEscapeStringa($valoreAttributo)  . "'";
//                        }
//                        break;
//
//                    case 'NULL':
//                        if (isset($valoriAttributiPadre))
//                        {
//                            $valoriAttributiPadre .= ", NULL ";
//                        }
//                        else
//                        {
//                            $valoriAttributiPadre = "NULL";
//                        }
//                        break;
//
//                    case 'double':
//                        if (isset($valoriAttributiPadre))
//                        {
//                            $valoriAttributiPadre .= ", '" . $valoreAttributo . "'";
//                        }
//                        else
//                        {
//                            $valoriAttributiPadre = "'" . $valoreAttributo  . "'";
//                        }
//                        break;
//
//                    case 'boolean':
//                        if($valoreAttributo === TRUE)
//                        {
//                            if (isset($valoriAttributiPadre))
//                            {
//                                $valoriAttributiPadre .= ", " . $valoreAttributo . "";
//                            }
//                            else
//                            {
//                                $valoriAttributiPadre = "'" . $valoreAttributo  . "'";
//                            }
//                        }
//                        else
//                        {
//                            if (isset($valoriAttributiPadre))
//                            {
//                                $valoriAttributiPadre .= ", 'FALSE'";
//                            }
//                            else
//                            {
//                                $valoriAttributiPadre = "FALSE";
//                            }
//                        }
//
//                        break;
//
//                    default:
//                        if (isset($valoriAttributiPadre))
//                        {
//                            $valoriAttributiPadre .= ", " . $valoreAttributo . "";
//                        }
//                        else
//                        {
//                            $valoriAttributiPadre = "" . $valoreAttributo . "";
//                        }
//                        break;
//                    }
//                $query1 = "INSERT INTO " . $nomeClassePadre. "(" . parent::$this->_attributiTabella . ") VALUES( " .  $valoriAttributiPadre . ")";  
//                }
//            
//        }  
//        else
//        {
//    //        $attributiTabella = get_object_vars($oggetto);
//    //        $attributiTabella = json_encode($attributiTabella);
//    //        print_r($attributiTabella);
//    //        print_r($nomeTabella);
//            $attributiTabella = explode(',', $this->_attributiTabella);
//            print_r($attributiTabella);
//            $valoriAttributi = NULL;
//            foreach ($attributiTabella as $valore) {
//                $valore = trim($valore);
//                $funzione = 'get'.$valore.$nomeClasse ;
//                print_r($funzione );
//                $valoreAttributo = $oggetto->$funzione();
//                print_r(gettype($valoreAttributo));
//                switch (gettype($valoreAttributo)) {
//                    case 'string':
//                    case 'text':
//                        if (isset($valoriAttributi))
//                        {
//                            $valoriAttributi .= ", '" . $this->trimEscapeStringa($valoreAttributo) . "'";
//                        }
//                        else
//                        {
//                            $valoriAttributi = "'" . $this->trimEscapeStringa($valoreAttributo)  . "'";
//                        }
//                        break;
//
//                    case 'NULL':
//                        if (isset($valoriAttributi))
//                        {
//                            $valoriAttributi .= ", NULL ";
//                        }
//                        else
//                        {
//                            $valoriAttributi = "NULL";
//                        }
//                        break;
//
//                    case 'mediumblob':
//                    case 'time':
//                    case 'date':
//                    case 'DateTime':
//                    case 'double':
//                        if (isset($valoriAttributi))
//                        {
//                            $valoriAttributi .= ", '" . $valoreAttributo . "'";
//                        }
//                        else
//                        {
//                            $valoriAttributi = "'" . $valoreAttributo  . "'";
//                        }
//                        break;
//
//                    case 'boolean':
//                        if($valoreAttributo === TRUE)
//                        {
//                            if (isset($valoriAttributi))
//                            {
//                                $valoriAttributi .= ", " . $valoreAttributo . "";
//                            }
//                            else
//                            {
//                                $valoriAttributi = "'" . $valoreAttributo  . "'";
//                            }
//                        }
//                        else
//                        {
//                            if (isset($valoriAttributi))
//                            {
//                                $valoriAttributi .= ", 'FALSE'";
//                            }
//                            else
//                            {
//                                $valoriAttributi = "FALSE";
//                            }
//                        }
//
//                        break;
//
//                    default:
//                        if (isset($valoriAttributi))
//                        {
//                            $valoriAttributi .= ", " . $valoreAttributo . "";
//                        }
//                        else
//                        {
//                            $valoriAttributi = "" . $valoreAttributo . "";
//                        }
//                        break;
//                }
//
//
//            }  
//
//            print_r($valoriAttributi);
//
//            $query = "INSERT INTO " . $this->_nomeTabella . "(" . $this->_attributiTabella . ") VALUES( " .  $valoriAttributi . ")";
//            return $this->eseguiQuery($query);   
//        }
    }
    
   
    
    
}
