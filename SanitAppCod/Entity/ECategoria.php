<?php

/**
 * La classe ECategoria si occupa della gestione in ram delle categorie.
 *
 * @package Entity
 * @author Claudia Di Marco & Riccardo Mantini
 */
class ECategoria {
    
    /**
     * @var string Il nome della categoria 
     */
    private $_nome;
    
    /**
     * @var array Gli esami che appartengono alla categoria.
     * Realizza l'aggregazione con la classe EEsame.
     */
    private $_esami = Array();
    
    /**
     * Costruttore della classe ECategoria.
     * 
     * @access public
     * @param string nome il nome della categoria
     */
    public function __construct($nome) {
        $this->_nome = $nome;  
        $this->_esami = Array();
    }
    
    /**
     * Metodo che ritorna il nome della categoria.
     * 
     * @access public
     * @return string Il nome della categoria
     */
    public function getNomeCategoria() {
        return $this->_nome;
    }
    
    /**
     * Metodo che ritorna gli esami associati alla categoria.
     * 
     * @access public
     * @return array Esami associati alla categoria
     */
    public function getEsamiCategoria() {
        return $this->_esami;
    }
    
    /**
     * Metodo che ritorna il nome della categoria.
     * 
     * @access public
     * @return string Il nome della categoria
     */
    public function setNomeCategoria() {
        return $this->_nome;
    }
    
    /**
     * Metodo che imposta gli esami associati alla categoria.
     * 
     * @access public
     * @param array $esami Esami associati alla categoria
     */
    public function setEsamiCategoria($esami) {
        $this->_esami = $esami;
    }
 
}
