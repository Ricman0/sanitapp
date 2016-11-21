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
class XDatiRefertoException {
    
    /**
     * Costruttore di XDatiRefertoException
     * 
     * @param Array $messaggi I messaggi dell'eccezione
     */
    public function __construct($messaggi) {
        foreach ($messaggi as $value) {
            $messaggio .= $value;
        }
        parent::__construct($messaggio);
        
    }

}
