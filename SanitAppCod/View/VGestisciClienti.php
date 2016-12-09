<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VGestisciClienti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciClienti extends View{

    /**
     * Metodo che permette di visualizzare tutti i clienti di una clinica
     * 
     * @access public
     * @param Array $risultato Un array di utenti pazienti di un medico
     */
    public function visualizzaClienti($risultato) 
    {
        $this->assegnaVariabiliTemplate('dati', $risultato);
        return $this->visualizzaTemplate('tabellaClienti');
    }
    
    /**
     * Metodo che consente di visualizzare le informazioni di un utente
     * 
     * @access public
     * @param EUtente $eUtente L'utente di cui si vogliono visualizzare le informazioni
     */
    public function visualizzaInfoUtente($eUtente) 
    {
        $this->assegnaVariabiliTemplate('utente', $eUtente);
        $this->visualizzaTemplate("infoUtente");
    }
}
