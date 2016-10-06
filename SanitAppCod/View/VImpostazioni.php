<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VImpostazioni
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VImpostazioni extends View{
    public function visualizzaImpostazioniUtente($utente)
    {  
       $this->assegnaVariabiliTemplate('utente', $utente);
       return $this->visualizzaTemplate('impostazioniUtente'); 
    }
}
