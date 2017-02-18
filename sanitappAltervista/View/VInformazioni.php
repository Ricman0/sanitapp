<?php

/**
 * La classe VInformazioni si occupa di visualizzare le informazioni dell'applicazione.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VInformazioni extends View {

    /**
     * Visualizza la pagina delle informazioni.
     * 
     * @access public
     */
    public function visualizzaInfo() {
        $this->visualizzaTemplate('infoValidazione');
    }
    
    /**
     * Visualizza la pagina dei contatti.
     * 
     * @access public
     * @param string $telefono Il telefono dell'amministratore
     * @param string $eMail L'email dell'amministratore
     * @param string $pec La PEC dell'amministratore
     */
    public function visualizzaContatti($telefono, $eMail, $pec) {
        
        $this->assegnaVariabiliTemplate('telefono', $telefono);
        $this->assegnaVariabiliTemplate('eMail', $eMail);
        $this->assegnaVariabiliTemplate('pec', $pec);
        $this->visualizzaTemplate('contatti');
        
    }
    
    /**
     * Visualizza la pagina della politica della privacy.
     * 
     * @access public
     */
    public function visualizzaPrivacyPolicy() {
        $this->visualizzaTemplate('privacyPolicy');
    }
    
    /**
     * Visualizza la pagina dei termini di servizio.
     * 
     * @access public
     */
    public function visualizzaTerminiServizio() {
        // tutta la apgina
        $log = $this->prelevaTemplate("log");
        $navBar = $this->prelevaTemplate("navigationBar");
        $main = $this->prelevaTemplate('terminiServizio');
        $this->assegnaVariabiliTemplate("logIn", $log);
        $this->assegnaVariabiliTemplate("navigationBar", $navBar);
        $this->assegnaVariabiliTemplate("mainRicerca", $main);
        $this->visualizzaTemplate("HomePage"); 
    }
}