<?php

/**
 * Classe XDatiException che definisce le eccezioni dei dati.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XDatiException extends Exception{
    
    /**
     * Costruttore di XDatiException.
     * 
     * @access public
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