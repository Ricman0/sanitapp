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
     * Metodo che consente di cercare se un un codice fiscale di un utente esiste o meno
     * 
     * @access public
     */
    public function gestisciRicerca()
    {
        
        $vRicerca = USingleton::getInstance('VRicerca');
        $codiceFiscale = $vRicerca->recuperaValore('codiceFiscaleRicercaUtente') ;
        $uValidazione = USingleton::getInstance('UValidazione');
        //imposto il risutlato della ricerca a NULL così che vada bene per il remote di JQUERY VALIDATION
        $risultato = NULL;
        if($uValidazione->validaCodiceFiscale($codiceFiscale))
        {
            //il codice fiscale  è valido
            // ora controllo che l'utente sia presente nel sistema
            $eUtente = new EUtente($codiceFiscale);
            
            
            if($eUtente->getCodiceFiscaleUtente()!==NULL)
            {
                
                //in questo caso è stato creato un utente dal codice fiscale
                // quindi il risultato sarà TRUE
                 $risultato = TRUE;
            }
                         
        }
        $vJSON = USingleton::getInstance('VJSON');
        $vJSON->inviaDatiJSON($risultato); 
    }
}
