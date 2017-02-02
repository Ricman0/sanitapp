<?php

/**
 * La classe CInformazioni si occupa della gestione delle informazioni sull'applicazione.
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CInformazioni {
    
    /**
     * Metodo che consente di impostare la pagina per le informazioni relative alla validazione.
     * 
     * @access public
     */
    public function visualizzaInfoPagina() {
        $vInfo = USingleton::getInstance('VInformazioni');
        $vInfo->visualizzaInfo();
    }
    
    /**
     * Metodo che consente di impostare la pagina per le informazioni relative ai contatti.
     * 
     * @access public
     */
    public function visualizzaContatti() {
        $eAmministratore = new EAmministratore();
        $vInformazioni = USingleton::getInstance('VInformazioni');
        $vInformazioni->visualizzaContatti($eAmministratore->getTelefonoAmministratore(), $eAmministratore->getEmailUser(), $eAmministratore->getPECUser());
        
    }

}
