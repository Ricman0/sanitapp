<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FCategoria
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FCategoria extends FDatabase{
    
    /**
     * Costruttore della classe FCategoria
     * 
     * @access public
     */
    public function __construct() {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "categoria";
        $this->_idTabella = "Nome";
        $this->_attributiTabella = "Nome";
    }
    
     /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di una categoria nel database
     * 
     * @access private
     * @param ECategoria $categoria la Categoria di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    public function getAttributi($categoria) 
    {
        print_r($categoria);
//        $valoriAttributi = '';
//        $x = get_object_vars($categoria);
//        print_r($x);
//        foreach ($categoria as $key => $value) {
//            if(empty($valoriAttributi))
//            {
//                $valoriAttributi = "'";
//                if(is_string($value))
//                {
//                    $valoriAttributi = $valoriAttributi . $this->trimEscapeStringa($value) . "'";
//                }
//                else
//                {
//                    $valoriAttributi = $valoriAttributi . $this->trim($value) . "'";
//                }
//                 
//            }
//            else 
//            {
//                $valoriAttributi = ", '";
//                if(is_string($value))
//                {
//                    $valoriAttributi = $valoriAttributi . $this->trimEscapeStringa($value) . "'";
//                }
//                else
//                {
//                    $valoriAttributi = $valoriAttributi . $this->trim($value) . "'";
//                }
//            }
            
//        }
//        print_r($valoriAttributi);
        
        $valoriAttributi = "'" . $this->trimEscapeStringa($categoria->getNome()) . "'";
        return $valoriAttributi;
    }
    
    /**
     * Metodo che permette di ottenere tutte le categorie
     * 
     * @access public
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return array|boolean Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     */
    public function cercaCategorie() {
        $query = 'SELECT * FROM ' .  $this->_nomeTabella . " LOCK IN SHARE MODE" ;
        $result = $this->eseguiQuery($query);
        return $result;
    }
    
    /**
     * Metodo che permette di aggiungere una categoria
     * 
     * @access public
     * @param ECategoria $categoria la Categoria che si vuole aggiungere 
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     */
    public function aggiungiCategoria($categoria) {
        
        $valoriAttributi = $this->getAttributi($categoria);
        $query = "INSERT INTO " . $this->_nomeTabella . "(" . $this->_attributiTabella . ") VALUES( " .  $valoriAttributi . ")";
        return $this->eseguiQuery($query);       
    }
    
    /**
     * Metodo che permette di aggiungere una categoria
     * 
     * @access public
     * @param string $nomeCategoria il nome della Categoria che si vuole eliminare
     * @throws XDBException Se la transazione non è stata eseguita con successo
     * @return boolean Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     */
    public function eliminaCategoria($nomeCategoria) {
        
        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
                ." WHERE Nome ='" . $nomeCategoria . "' FOR UPDATE" ;
        $query = "DELETE FROM " . $this->_nomeTabella . " WHERE Nome ='" . $nomeCategoria . "'" ;
     
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
}
