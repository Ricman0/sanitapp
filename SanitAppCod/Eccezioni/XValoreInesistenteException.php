<?php

/**
 * Classe XValoreInesistenteException che definisce le eccezioni dei valori inesistenti.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XValoreInesistenteException extends Exception{
    /**
     * Costruttore di XValoreInesistenteException 
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }
    
}
