<?php

/**
 * Classe XDatiRefertoException che definisce le eccezioni dei dati del referto.
 * 
 * @package Eccezioni
 * @author Claudia Di Marco & Riccardo Mantini
 */
class XDatiRefertoException extends Exception{
    
    /**
     * Costruttore di XDatiRefertoException
     * 
     * @access public
     * @param array|string $messaggi I messaggi dell'eccezione
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
