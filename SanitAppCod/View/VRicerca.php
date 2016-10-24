<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VRicerca
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VRicerca extends View{
    
    public function getCodiceFiscale() 
    {
        if (isset($_REQUEST['codice'])) 
            {
                return $_REQUEST['codice'];
            } 
        else 
            {
                return "FALSE";
            }
    }
    
    /**
     * Metodo che consente di inviare il risultato della ricerca in maniera JSON
     * 
     * @param string $risultato Il risultato della ricerca
     */
//    public function inviaRisultato($risultato)
//    {
//        echo $this->json_encode($risultato);
//    }
}
