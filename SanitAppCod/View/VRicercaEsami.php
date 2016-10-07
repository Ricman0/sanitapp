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
        $this->assegnaVariabiliTemplate('controller', "esami");
        return $this->visualizzaTemplate('tabellaEsami');
    }
    
    /**
     * 
     * @param EEsame $esame 
     * @param boolean $servizi TRUE se siamo nella pagina personale della clinica, FALSE altrimenti
     * @return type
     */
    public function visualizzaInfoEsameOspite($esame, $servizi) 
    {
        echo " visualizzaInfoEsame ";
        print_r($esame);
        $this->assegnaVariabiliTemplate('esame', $esame);
        $this->assegnaVariabiliTemplate('tipo', $servizi);
        return $this->visualizzaTemplate("infoEsame");
        
    }
}