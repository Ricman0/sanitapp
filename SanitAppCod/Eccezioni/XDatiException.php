<?php

/**
 * Description of XDatiException
 *
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XDatiException extends Exception{
    
    /**
     * Costruttore di XDatiException
     * 
     * @param array $messaggi I messaggi dell'eccezione
     */
    public function __construct($messaggi) {
        
        if(is_array($messaggi))
        {
            $messaggio = '';
            foreach ($messaggi as $value) {
            $messaggio .= $value;
            }
        }
        else
        {
            $messaggio = $messaggi;
        }
        
        parent::__construct($messaggio);
        
    }
}