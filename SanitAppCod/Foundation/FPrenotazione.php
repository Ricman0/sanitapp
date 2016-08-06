<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FPrenotazione
 *
 * @package Foundation
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FPrenotazione extends FDatabase{
    
    /**
     * Costruttore della classe FPrenotazione
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "prenotazione";
        // imposto gli attributiTabella
        $this->_attributiTabella = "IDPrenotazione, " + "IDEsame, " + "PartitaIVAclinica, " +
                + "Tipo, " + "Confermata, " + "Eseguita, "+ "CodFiscaleUtenteEffettuaEsame, " 
                + "CodFiscaleMedicoPrenotaEsame, "+ "CodFiscaleUtentePrenotaEsame, "
                + "DataEOra";
    }
}
