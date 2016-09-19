<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VRicercaCliniche
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VRicercaCliniche extends View{
    
    /**
     * Metodo che consente di poter restituire la form per la ricerca delle
     * cliniche
     * 
     * @access public
     * @return type Description
     */
    public function restituisciFormRicercaCliniche() 
    {
        return $this->visualizzaTemplate('ricercaCliniche');
    }
    
    /**
     * Metodo che consente di visualizzare il risultato della ricerca delle cliniche
     * in una tabella.
     * 
     * @access public
     */
    public function restituisciPaginaRisultatoCliniche($risultato) 
    {
        //http://stackoverflow.com/questions/29297553/smarty-populate-html-table-columns-with-smarty-array-variable
        // html table nella documentazione di smarty
        $this->assegnaVariabiliTemplate('dati', $risultato);
        return $this->visualizzaTemplate('tabellaCliniche');
    }
    
}
