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
     * @var array $_result è un array contenente il risultato della query
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
    protected $_attributiTabella;
    
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
            echo 'Connessione stabilita ' . $this->_connessione->host_info . "\n";
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
     * Metodo che permette di effettuare l'escape dei caratteri speciali di una stringa
     * 
     * @final
     * @access public
     * @param string $string La stringa di cui si vuole effettuare l'escape
     * @return string La stringa di cui si è fatto l'escape
     */
    final public function escapeStringa($string) 
    {
        $stringa = $this->_connessione->real_escape_string($string);
        return $stringa;
    }
    
    
    
    /**
     * Metodo che consente di eseguire una query 
     * 
     * @final
     * @access public
     * @param string $query La query da eseguire
     * @return array|boolean Se la query è stata eseguita con successo, ..., in caso contrario resituirà false.
     */
    final public function eseguiQuery($query) 
    {
        //$this->_result = array();  // secondo me possiamo eliminare questa riga  dal momento che è già stato inizializzata così
        // eseguo la query e salvo il risultato in $queryResult
        $queryResult = $this->_connessione->query($query);
        // se il risultato della query è false
        if(!$queryResult)
            {
                die ("Errore mysql durante l'esecuzione della query: " . $this->_connessione->error);
            }
        else
            {
                /*
                 * una volta che si è sicuri che in $queryResult è contenuto il
                 * risultato della query, si può usare tale variabile per 
                 * estrarre i dati una alla volta usando il metodo fetch_assoc
                 * dell'oggetto.
                 * la funzione fetch_assoc() ritorna la riga successiva
                 */
                 
                while ($row = $queryResult->fetch_assoc()) 
                {
                    $this->_result[] = $row;
                }
                echo 'Query eseguita con successo: un nuovo utente è stato inserito';
                return $this->_result;

            }
        
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
}
