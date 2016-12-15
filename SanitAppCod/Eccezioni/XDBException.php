<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
