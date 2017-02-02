<?php
/**
 * La classe VContatti
 *
 * @package View
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
