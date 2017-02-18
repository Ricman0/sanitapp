<?php

/**
 * Classe XUtenteException che definisce le eccezioni dell'utente.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XUtenteException extends XUserException{
    /**
     * Costruttore di XUtenteException.
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
