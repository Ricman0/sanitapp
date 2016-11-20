<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XUtenteException
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XUtenteException extends Exception{
    /**
     * Costruttore di XUtenteException
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
