<?php

/**
 * Description of XDBException
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XDBException extends Exception{
    
    /**
     * Costruttore di XDBException
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
