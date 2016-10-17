<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FDB
 *
 * 
 * @package Foundation
 * @author Claudia Di Marco & Riccardo Mantini
 */

class FDB {
    
    /*
     * Attributi della classe FDB
     */
    
    /**
     * @var $_connessione Variabile per la connessione al database
     */
    private $_connessione; 
    
    /**
     * @var $_nomeTabella Il nome della tabella con cui si interagisce
     */
    private $_nomeTabella; 
    
    /**
     *Metodo per connettersi ad un database server
     *  
     * @access public
     * @param string $hostname Il nome dell'host o l'indirizzo IP del server 
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
    public function connessioneDB($hostname, $username, $password, $database)
    {
        // memorizzo la resource della connessione in $_connessione
        $this->_connessione = @new mysqli($hostname, $username, $password, $database);
        //mysqli_connect_errno() restituisce 0 quando non vi sono errori
        //durante la connessione o un codice di errore quando sorge un problema
        //ho cambiato la if: if(mysqli_connect_errno()!=0) sostituita
        if ($this->_connessione->connect_errno != 0)
        { 
            //mysqli_connect_error() usato per acquisire il messaggio di testo di errore
            $messaggioErrore = $this->_connessione->connect_error;
            echo 'Errore di connessione ('.$this->_connessione->connect_errno.')'.$messaggioErrore;
            return false; 
            //oppure die('Errore di connessione ('.mysqli_connect_errno().')'.$messaggioErrore);
            // ed eliminare la riga echo e quella return
        }
        else
        {
            echo 'Connessione stabilita' . $this->_connessione->host_info . "\n";
            //imposto il set di caratteri utf8 per la connessione
            
//            $this->_connessione->set_charset("utf8");
//            echo ($this->_connessione->character_set_name());
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
     * Metodo per inserire nella tabella Utente una nuova riga ovvero
     * un nuovo utente
     * 
     * @param EUtente $utente L'oggetto di tipo EUtente che si vuole salvare nella
     *                       tabella Utente
     * 
     * @return boolean TRUE se l'utente è stato inserito correttamente, FALSE in
     *                 caso contrario.
     */
    public function inserisciUtente($utente)
    { 
        $valoriAttributi = "";
        $i = 1;
        foreach ($utente as $key => $value) 
        {
            if($i < count($utente) )
            {
                $_attributiTabella = $_attributiTabella ."`" . $key . "`,";
                $valoriAttributi = $valoriAttributi . "`" . $value . "`," ;
            }
            else
            {
                $_attributiTabella = $_attributiTabella . "`" . $key . "`";
                $valoriAttributi = $valoriAttributi . "`" . $value . "`" ;
            }
            $i++;
        }
        $query = 'INSERT INTO Utente('. $_attributiTabella .') VALUES('. $valoriAttributi.')';
        $inserito = $this->_connessione->query($query);
        if ($inserito === TRUE)
        {
            echo 'Utente inserito correttamente nel database';
        }
        else 
        {
            echo "Si è verifica un errore durante l'inserimento ". $this->_connessione->error;
        }
        return $inserito;
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
     * Metodo che permette di modificare un attributo di una tupla utente
     * 
     * @param string $attributo Il nome della colonna nella tabella utente 
     *               di cui si vuole modificare il valore del contenuto
     * @param string $valore Il valore con il quale modificare il vecchio valore
     */
    /**
     * Metodo per chiude la connessione con il database
     * 
     * @return type Description
     */
    public function terminaConnessioneDB()
    {
        //clean up, chiusura della connessione
        $this->_connessione->close();
    }
}
