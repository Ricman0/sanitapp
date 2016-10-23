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
        if (isset($_REQUEST['codiceFiscale'])) 
            {
                return $_REQUEST['codiceFiscale'];
            } 
        else 
            {
                return "FALSE";
            }
    }
}
