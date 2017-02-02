<?php

/**
 * Classe XMedicoException che definisce le eccezioni del medico.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XMedicoException extends XUserException{
    /**
     * Costruttore di XMedicoException. 
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }
}
