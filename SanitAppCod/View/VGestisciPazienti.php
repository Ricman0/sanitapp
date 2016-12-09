<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VGestisciPazienti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciPazienti extends View{
    
    /**
     * Metodo che permette di visualizzare tutti i pazienti di un medico
     * 
     * @access public
     * @param Array $risultato Un array di utenti pazienti di un medico
     */
    public function visualizzaPazienti($risultato) 
    {
        if(count($risultato)>0)
        {
            $this->assegnaVariabiliTemplate('pazienti', TRUE);
            $this->assegnaVariabiliTemplate('dati', $risultato);
        } 
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        return $this->visualizzaTemplate('tabellaPazienti');
    }
    
    /**
     * Metodo che consente di visualizzare tutte le informazioni relative ad un 
     * utente passato per paramentro
     * 
     * @access public
     * @param type $utente L'utente di cui si vuole conoscere le informazioni
     */
    public function visualizzaInfoUtente($utente) 
    {
        $this->assegnaVariabiliTemplate('utente', $utente);
        $this->visualizzaTemplate("infoUtente");
    }
    
    /**
     * Metodo che consente di visualizzare la form per aggiungere un nuovo paziente
     * 
     * @access public
     */
    public function restituisciFormAggiungiPaziente() 
    {
        $this->visualizzaTemplate("inserisciUtente");
    }
}
