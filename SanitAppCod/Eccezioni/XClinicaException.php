<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XClinicaException
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XClinicaException extends Exception{
    /**
     * Costruttore di XClinicaException
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }
}
