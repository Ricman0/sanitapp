<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CContatti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CContatti {
    /**
     * Visualizza la pagina dei contatti
     */
    public function visualizzaContatti() {
        
        $eAmministratore = new EAmministratore();
        $vContatti = USingleton::getInstance('VContatti');
        $vContatti->visualizzaContatti($eAmministratore->getTelefonoAmministratore(), $eAmministratore->getEmailUser(), $eAmministratore->getPECUser());
        
    }
}
