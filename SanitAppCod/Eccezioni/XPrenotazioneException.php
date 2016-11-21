<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XPrenotazioneException
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XPrenotazioneException extends Exception{
    /**
     * Costruttore di XPrenotazioneException 
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }
}
