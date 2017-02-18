<?php

/**
 * Classe XAmministratoreException che definisce le eccezioni per l'amministratore.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XAmministratoreException extends XUserException{
    /**
     * Costruttore di XAmministratoreException.
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
