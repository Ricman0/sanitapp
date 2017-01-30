<?php

/**
 * Description of VEsami
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VEsami extends View{
    
    /**
     * Metodo che consente di restituire e visualizzare la form per effettuare la ricerca degli esami.
     * 
     * @access public
     */
    public function restituisciFormRicercaEsami() 
    {
        $this->visualizzaTemplate('ricercaEsami');
    }
    
    /**
     * Metodo che consente di visualizzare attraverso una tabella gli esami risultato della ricerca.
     * 
     * @access public
     * @param array $dati Gli esami da visualizzare
     */
    public function restituisciPaginaRisultatoEsami($dati) 
    {
        $this->visualizzaTemplate('tabellaEsami');
    }
}