<?php

/**
 * Classe XMailException che definisce le eccezioni della mail.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XMailException extends Exception{
    /**
     * Costruttore di XMailException 
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }
}
