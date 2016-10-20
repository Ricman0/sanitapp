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
        echo "visualizzaClienti";
        $this->assegnaVariabiliTemplate('dati', $risultato);
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        return $this->visualizzaTemplate('tabellaClienti');
    }
}
