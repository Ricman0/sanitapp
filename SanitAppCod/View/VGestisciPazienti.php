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
    
    public function visualizzaPazienti($risultato) 
    {
        echo "visualizzaPazienti";
        $this->assegnaVariabiliTemplate('dati', $risultato);
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        return $this->visualizzaTemplate('tabellaPazienti');
    }
}
