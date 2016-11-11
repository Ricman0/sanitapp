<?php

/**
 * Description of VRicercaEsami
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VRicercaEsami extends View{
    
    /**
     * Metodo che consente di poter restituire la form per la ricerca degli
     * esami
     * 
     * @access public
     */
    public function restituisciFormRicercaEsami() 
    {
        $this->visualizzaTemplate('ricercaEsami');
    }
    
    /**
     * Metodo che consente di visualizzare il risultato della ricerca degli esami
     * in una tabella.
     * 
     * @access public
     * @param array $esami Array contentente gli esami
     */
    public function restituisciPaginaRisultatoEsami($esami) 
    {
        //http://stackoverflow.com/questions/29297553/smarty-populate-html-table-columns-with-smarty-array-variable
        // html table nella documentazione di smarty
        $this->assegnaVariabiliTemplate('dati', $esami);
        $this->assegnaVariabiliTemplate('controller', "esami");
        $this->visualizzaTemplate('tabellaEsami');
    }
    
    /**
     * Metodo che consente di visualizzare le informazioni di un esame 
     * 
     * @param EEsame $esame 
     * @param boolean $servizi TRUE se siamo nella pagina personale della clinica, FALSE altrimenti
     */
    public function visualizzaInfoEsameOspite($esame, $servizi, $codiceFiscaleUtentePrenotaEsame=NULL) 
    {
        $this->assegnaVariabiliTemplate('esame', $esame);
        $this->assegnaVariabiliTemplate('tipo', $servizi);
        $this->assegnaVariabiliTemplate('codiceFiscale', $codiceFiscaleUtentePrenotaEsame);
        $this->visualizzaTemplate("infoEsame");
        
    }
}