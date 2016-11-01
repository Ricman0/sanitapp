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


    /**
     * Metodo che consente di visualizzare tutti i referti di uno user
     * 
     * @access public
     * @param Array $referti I referti da visualizzare
     * @param string $tipoUser Il tipo di user
     */
    public function restituisciPaginaRisultatoReferti($referti, $tipoUser) 
    {
        echo "$tipoUser";
        if($tipoUser==='clinica')
        {
            $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        }
        else
        {
            $this->assegnaVariabiliTemplate('tastoAggiungi', FALSE);
        }
        $this->assegnaVariabiliTemplate('tipoUser', $tipoUser);
        $this->assegnaVariabiliTemplate('dati', $referti);
        $this->visualizzaTemplate('tabellaReferti');
    }
    
    
    public function restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame) {
        
        $this->assegnaVariabiliTemplate('idPrenotazione', $idPrenotazione);
        $this->assegnaVariabiliTemplate('idEsame', $idEsame);
        $this->assegnaVariabiliTemplate('partitaIva', $partitaIva);
        $this->assegnaVariabiliTemplate('medicoEsame', $medicoEsame);
        return $this->visualizzaTemplate('aggiungiReferto');
        
    }
    
    
}
