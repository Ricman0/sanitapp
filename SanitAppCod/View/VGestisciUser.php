<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VGestisciUser
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciUser extends View{
    /**
     * Metodo che permette di visualizzare tutti gli user dell'applicazione fatta eccezione per gli amministratori
     * 
     * @access public
     * @param Array $risultato Un array di user (non amministratori)
     */
    public function visualizzaUserNonAmministratori($risultato) 
    {
        if(count($risultato)>0)
        {
            $this->assegnaVariabiliTemplate('user', TRUE);
            $this->assegnaVariabiliTemplate('dati', $risultato);
        }
        $this->visualizzaTemplate('tabellaUser');
    }
}
