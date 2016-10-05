<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VGestioneServizi
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestioneServizi extends View{
    
    public function restituisciFormAggiungiServizi($listaCategorie)
    {
        $this->assegnaVariabiliTemplate('categorie', $listaCategorie);
        return $this->visualizzaTemplate('aggiungiEsame'); 
    }
    
    public function visualizzaEsami($risultato)
    {
        $this->assegnaVariabiliTemplate('dati', $risultato);
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        return $this->visualizzaTemplate('tabellaEsami');
    }
    
    
    public function visualizzaInfoEsame($esame) 
    {
        echo " visualizzaInfoEsame ";
        print_r($esame);
        $this->prelevaTemplate("infoEsame");
        $this->assegnaVariabiliTemplate('esame', $esame);
        return $this->visualizzaTemplate("infoEsame");
        
    }
    
    
}
