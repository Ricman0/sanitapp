<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XAmministratoreException
 *
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XAmministratoreException extends XUserException{
    /**
     * Costruttore di XAmministratoreException
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
