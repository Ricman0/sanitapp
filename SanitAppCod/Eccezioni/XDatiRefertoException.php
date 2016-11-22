<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XDatiRefertoException
 *
 * @author Riccardo
 */
class XDatiRefertoException extends Exception{
    
    /**
     * Costruttore di XDatiRefertoException
     * 
     * @param Array|string $messaggi I messaggi dell'eccezione
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
