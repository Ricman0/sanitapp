<?php

/**
 * Classe XPrenotazioneException che definisce le eccezioni della prenotazione.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XPrenotazioneException extends Exception{
    /**
     * Costruttore di XPrenotazioneException. 
     * 
     * @access public
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }
}
