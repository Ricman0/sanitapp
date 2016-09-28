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
    
    public function restituisciFormAggiungiServizi()
    {
        return $this->visualizzaTemplate('aggiungiEsame'); 
    }
}
