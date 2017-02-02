<?php

/**
 * Classe XEsameException che definisce le eccezioni dell'esame.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XEsameException extends Exception{
    /**
     * Costruttore di XEsameException.
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }
}
