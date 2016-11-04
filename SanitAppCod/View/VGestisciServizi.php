<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VGestisciServizi
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciServizi extends View{
    
    public function restituisciFormAggiungiServizi($listaCategorie)
    {
        $this->assegnaVariabiliTemplate('categorie', $listaCategorie);
        return $this->visualizzaTemplate('aggiungiEsame'); 
    }
    
    public function visualizzaEsami($risultato)
    {
        $this->assegnaVariabiliTemplate('dati', $risultato);
        $this->assegnaVariabiliTemplate("controller", "servizi");
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        return $this->visualizzaTemplate('tabellaEsami');
    }
    
    
    public function visualizzaInfoEsame($esame, $servizi) 
    {
        $this->assegnaVariabiliTemplate('esame', $esame);
        $this->assegnaVariabiliTemplate('servizi', $servizi);
        $this->visualizzaTemplate("infoEsame");
        
    }
    
    
}
