<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VContatti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VContatti extends View{
    
    public function visualizzaContatti($telefono, $eMail, $pec) {
        
        $this->assegnaVariabiliTemplate('telefono', $telefono);
        $this->assegnaVariabiliTemplate('eMail', $eMail);
        $this->assegnaVariabiliTemplate('pec', $pec);
        $this->visualizzaTemplate('contatti');
        
    }
    
}
