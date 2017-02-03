<?php

/**
 * Classe XRefertoException che definisce le eccezioni del referto.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XRefertoException extends Exception{
    /**
     * Costruttore di XReferoException.
     * 
     * @access public
     * param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}