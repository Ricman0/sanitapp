<?php

/**
 * Classe XDatiLogInException che definisce le eccezioni per l'autenticazione dello user.
 *
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XDatiLogInException extends Exception{
    
    /**
     * Costruttore di XDatiLogInException
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }
}
