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
}
