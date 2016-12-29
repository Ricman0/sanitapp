<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VSetup
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VSetup extends View{

    public function restituisciPaginaInstallazione() {
        
        $this->visualizzaTemplate('installazione');
        
    }
    
}
