<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FReferto
 *
 * @author Riccardo
 */
class FReferto extends FDatabase{
    /**
     * 
     * @param type $partitaIvaClinica
     */
    public function cercaRefertiClinica($partitaIVAClinica) 
    {
        
        $query =   "SELECT IDReferto, esame.IDEsame, prenotazione.IDPrenotazione, esame.NomeEsame, utente.Nome, utente.Cognome, "
                . "DataReferto, prenotazione.CodFiscaleUtenteEffettuaEsame "
                . "FROM referto, prenotazione, esame, utente "
                . "WHERE ((referto.IDPrenotazione=prenotazione.IDPrenotazione) AND (referto.IDEsame=esame.IDEsame) AND "
                . "(prenotazione.CodFiscaleUtenteEffettuaEsame=utente.CodFiscale) AND "
                . "(referto.PartitaIVAClinica='" . $partitaIVAClinica . "')) ";
        $risultato = $this->eseguiQuery($query);
        print_r($risultato);
        return $risultato;
        
    }
}
