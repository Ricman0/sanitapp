<?php

/**
 * La classe FCategoria si occupa della gestione della tabella 'categoria'. 
 *
 * @package Foundation
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
        $this->_nomeColonnaPKTabella = "Nome";
        $this->_attributiTabella = "Nome";
    }
    
    
    /**
     * Metodo che permette di ottenere tutte le categorie.
     * 
     * @access public
     * @return array Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
//    public function cercaCategorie() {
//        $query = 'SELECT * FROM ' .  $this->_nomeTabella . " LOCK IN SHARE MODE" ;
//        return $this->eseguiQuery($query);
//    }
    
    /**
     * Metodo che permette di aggiungere una categoria.
     * 
     * @access public
     * @param ECategoria $categoria la Categoria che si vuole aggiungere 
     * @return boolean Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
//    public function aggiungiCategoria($categoria) {
//        
//        $valoriAttributi = $this->getAttributi($categoria);
//        $query = "INSERT INTO " . $this->_nomeTabella . "(" . $this->_attributiTabella . ") VALUES( " .  $valoriAttributi . ")";
//        return $this->eseguiQuery($query);       
//    }
    
    /**
     * Metodo che permette di aggiungere una categoria.
     * 
     * @access public
     * @param string $nomeCategoria il nome della Categoria che si vuole eliminare
     * @return boolean Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
//    public function eliminaCategoria($nomeCategoria) {
//        
//        $queryLock = "SELECT * FROM " . $this->_nomeTabella 
//                ." WHERE Nome ='" . $nomeCategoria . "' FOR UPDATE" ;
//        $query = "DELETE FROM " . $this->_nomeTabella . " WHERE Nome ='" . $nomeCategoria . "'" ;
//     
//        try {
//            // inzia la transazione
//            $this->_connessione->begin_transaction();
//
//            // le query che devono essere eseguite nella transazione. se una fallisce, un'exception è lanciata
//            $this->eseguiquery($queryLock);
//            $this->eseguiQuery($query);
//
//            // se non ci sono state eccezioni, nessuna query della transazione è fallita per cui possiamo fare il commit
//            return $this->_connessione->commit();
//        } catch (Exception $e) {
//            // un'eccezione è lanciata, per cui dobbiamo fare il rollback della transazione
//            $this->_connessione->rollback();
//            throw new XDBException('errore');
//        }
        
//    }
}
