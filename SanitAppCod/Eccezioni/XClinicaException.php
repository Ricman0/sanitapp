<?php

/**
 * Classe XCategoriaException che definisce le eccezioni per le categorie.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XClinicaException extends XUserException{
    /**
     * Costruttore di XClinicaException.
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
