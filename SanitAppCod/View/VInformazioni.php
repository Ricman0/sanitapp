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
}