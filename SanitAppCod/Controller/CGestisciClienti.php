<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CClienti
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestisciClienti {
    
    /**
     * Metodo che consente di gestire le richieste avente come controller Clienti
     * 
     * @access public
     */
    public function gestisciClienti() 
    {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');        
        $vClienti = USingleton::getInstance('VGestisciClienti');
        $task = $vClienti->getTask();
        switch ($task) 
        {
            case 'visualizza':
                $tipoUser = $sessione->leggiVariabileSessione('tipoUser');// secondo te devo controllare che il tipo di utente sia una clinica??
                if ($tipoUser === 'clinica')
                {
                    
//                    $partitaIVA = $eClinica->getPartitaIVAClinica();
                    $cf = $vClienti->recuperaValore('id');
                    if ($cf === FALSE)
                    {
                        // vogliamo visualizzare tutti i pazienti del medico
                        $eClinica = new EClinica($username);
                        $risultato = $eClinica->cercaClienti();          
                        $vClienti->visualizzaClienti($risultato);
                        
                    }
                    else
                        {
                         // si cerca un solo paziente
            //                $eMedico = new Medico();
                                $futente = USingleton::getInstance('FUtente');
                                $utenteCercato = $futente->cercaUtenteByCF($cf);
                                $vClienti->visualizzaInfoUtente($utenteCercato[0]);
                        }
                    
                }
                else
                {
                    echo ' errore in CGestisciClienti visualizza ';
                }
                break;

            default:
                break;
        }
        
        
    }
}
