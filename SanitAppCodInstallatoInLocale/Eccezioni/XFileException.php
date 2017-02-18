<?php

/**
 * Classe XFileException che definisce le eccezioni del file.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XFileException extends Exception{
    /**
     * Costruttore di XFileException.
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
