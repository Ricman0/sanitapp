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
    private function getAttributi($categoria) 
    {
        $valoriAttributi = "'" . $this->trimEscapeStringa($categoria->getNome()) . "'";
        return $valoriAttributi;
    }
    
    /**
     * Metodo che permette di ottenere tutte le categorie
     * 
     * 
     * @return array|boolean Se la query è stata eseguita con successo, ..., in caso contrario resituirà false.
     */
    public function cercaCategorie() {
        
        $query = 'SELECT * FROM ' .  $this->_nomeTabella ;
        $result = $this->eseguiQuery($query);
        return $result;
    }
}
