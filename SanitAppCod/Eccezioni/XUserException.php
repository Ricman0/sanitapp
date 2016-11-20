<?php


/**
 * Classe di eccezioni lanciate dalla classe EUser
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XUserException extends Exception{
   
    /**
     * Costruttore di XUserException
     * 
     * @param string $messaggio Il messaggio dell'eccezione
     */
    public function __construct($messaggio) {
        parent::__construct($messaggio);
    }





}
