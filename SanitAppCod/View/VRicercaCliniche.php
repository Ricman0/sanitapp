<?php

/**
 * La classe VRicercaCliniche  permette la visualizzazione della giusta pagina per il controller CRicercaCliniche.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VRicercaCliniche extends View{
    
    /**
     * Metodo che consente di poter restituire la form per la ricerca delle
     * cliniche.
     * 
     * @access public
     */
    public function restituisciFormRicercaCliniche()                            //controllato
    {
        $this->visualizzaTemplate('ricercaCliniche');
    }
    
    
    /**
     * Metodo che consente di visualizzare il risultato della ricerca delle cliniche
     * in una tabella.
     * 
     * @access public
     * @param array $cliniche Array contentente le cliniche
     */
    public function restituisciPaginaRisultatoCliniche($cliniche) 
    {
        $this->assegnaVariabiliTemplate('dati', $cliniche);
        $this->visualizzaTemplate('tabellaCliniche');
    }
    
    /**
     * 
     * @param EClinica $clinica 
     * @return type
     */
    public function visualizzaInfoClinicaOspite($clinica) 
    {
        $this->assegnaVariabiliTemplate('clinica', $clinica);
        return $this->visualizzaTemplate("infoClinica");
        
    }
    
}
