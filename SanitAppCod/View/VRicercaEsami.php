<?php

/**
 * 
 */
class VRicercaEsami extends View{
    
    public function restituisciFormRicercaEsami() 
    {
        return $this->visualizzaTemplate('ricercaEsami');
    }
    
    public function restituisciPaginaRisultatoEsami($risultato) 
    {
        //http://stackoverflow.com/questions/29297553/smarty-populate-html-table-columns-with-smarty-array-variable
        // html table nella documentazione di smarty
        $this->assegnaVariabiliTemplate('dati', $risultato);
        return $this->visualizzaTemplate('tabellaEsami');
    }
}