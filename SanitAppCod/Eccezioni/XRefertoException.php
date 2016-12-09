<?php


/**
 * Description of XRefertoException
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XRefertoException extends Exception{
    /**
     * Costruttore di XReferoException
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}