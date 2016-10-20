<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VReferti
 *
 * @author Claudia Di Marco & Riccardo Mantini 
 */
class VReferti extends View{

    public function restituisciPaginaRisultatoRefertiClinica($referti) {
        
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        $this->assegnaVariabiliTemplate('dati', $referti);
        return $this->visualizzaTemplate('tabellaRefertiClinica');
    }
}
