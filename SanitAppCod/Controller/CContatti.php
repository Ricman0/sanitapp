<?php

/**
 * La classe CContatti permette di gestire 
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CContatti {
    /**
     * Visualizza la pagina dei contatti.
     * 
     */
    public function visualizzaContatti() {
        
        $eAmministratore = new EAmministratore();
        $vContatti = USingleton::getInstance('VContatti');
        $vContatti->visualizzaContatti($eAmministratore->getTelefonoAmministratore(), $eAmministratore->getEmailUser(), $eAmministratore->getPECUser());
        
    }
}
