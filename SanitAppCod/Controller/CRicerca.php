<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CRicerca
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicerca {
    /**
     * Metodo che
     * 
     * @access public
     */
    public function gestisciRicerca()
    {
        
        $vRicerca = USingleton::getInstance('VRicerca');
        $codiceFiscale = $vRicerca->getCodiceFiscale();
        $uValidazione = USingleton::getInstance('UValidazione');
        if($uValidazione->validaCodiceFiscale($codiceFiscale))
        {
            //il codice fiscale  è valido
            // ora controllo che l'utente sia presente nel sistema
            $eUtente = new EUtente($codiceFiscale);
            //imposto il risutlato della ricerca a NO
            $risultato['risultato'] = "NO";
            if($eUtente->getCodiceFiscaleUtente()!==NULL)
            {
                
                //in questo caso è stato creato un utente dal codice fiscale
                // quindi il risultato sarà SI
                $risultato['risultato'] = "SI";
            }
            echo json_encode($risultato);
            
            
        }
    }
}
