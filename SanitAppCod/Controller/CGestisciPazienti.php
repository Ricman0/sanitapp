<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestisciPazienti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciPazienti {
    
    /**
     * Metodo che consente la visualizzazione di un paziente passato come parametro o tutti i pazienti
     * 
     * @access public
     */
    public function gestisciPazienti() 
    {
        echo "gestione pazienti in CGestionePAzienti";
        $sessione = USingleton::getInstance('USession');
        $usernameMedico = $sessione->leggiVariabileSessione('usernameLogIn');
        $vPazienti = USingleton::getInstance('VGestisciPazienti');
        $task =$vPazienti->getTask();
        switch ($task) {
            case 'visualizza':
                
                echo "case visualizza di gestione pazienti in CGestionePazienti";
//                $this->visualizza($vPazienti,$usernameMedico);
                $medico = USingleton::getInstance('FMedico');
                $risultato = $medico->cercaPazienti($usernameMedico);  
                if (is_array($risultato))
                {
                    $vPazienti->visualizzaPazienti($risultato);
                }
                else { "problema in cerca esami";}
                break;

            default:
                break;
        }
        
        
        
        
        
    }
    
    private function visualizza($vPazienti,$usernameMedico) 
    {
        $cf = $vPazienti->getId();
        if ($cf === FALSE)
        {
            // vogliamo visualizzare tutti i pazienti del medico
            $medico = USingleton::getInstance('FMedico');
            $risultato = $medico->cercaPazienti($usernameMedico);  
            if (is_array($risultato))
            {
                $vPazienti->visualizzaPazienti($risultato);
            }
        }
        else
            {
             // si cerca un solo paziente
            }
    }
}
