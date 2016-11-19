<?php


/**
 * Classe di eccezioni lanciate dalla classe EUser
 *
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class UserException extends Exception{
   
    /**
     * Costruttore di UserException
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
        
    }





}
