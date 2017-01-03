<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ECategoria
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class ECategoria {
    
    
    private $_nome;
    
    /*
     * Costruttore della classe Categoria
     * 
     * @param string nome il nome della categoria
     */
    public function __construct($nome) {
        
        $this->_nome = $nome;
        
    }
    
    /*
     * Metodo che ritorna il nome della categoria
     * 
     * @return type string  nome della categoria
     */
    public function getNome() {
        return $this->_nome;
    }
    
    /**
     * Metodo che consente di aggiungere una categoria.
     * 
     * @access public
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     */
    public function aggiungiCategoria() {
        $fCategorie = USingleton::getInstance('FCategoria');
        return $fCategorie->aggiungiCategoria($this); 
    }
    
}
