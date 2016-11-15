<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CImpostazioni
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CImpostazioni {

    public function gestisciImpostazioni() {
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $tipoUser = $sessione->leggiVariabileSessione('tipoUser');
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $task = $vImpostazioni->getTask();
        switch ($task) 
        {
            case 'giorniNonLavorativi':                
                $partitaIVAClinica = $vImpostazioni->recuperaValore('clinica');
                $eClinica = new EClinica(NULL, $partitaIVAClinica);
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON($eClinica->getGiorniNonLavorativi());                
                break;
            
            case 'visualizza': 
            {
                switch ($tipoUser) 
                {
                    case 'utente':                
                        $eUtente = new EUtente(NULL, $username);
                        $vImpostazioni->visualizzaImpostazioniUtente($eUtente);
                        break;

                    case 'clinica':
                        
                        {
                            $eClinica = new EClinica($username);                            
                            $vImpostazioni->visualizzaImpostazioniClinica($eClinica->getWorkingPlanClinica());
                        }
                        break;

                    default:
                        break;
                }
            }
            break;
            
            case 'modifica':
            {
                switch ($tipoUser) 
                {
                    case 'utente':                
                        $eUtente = new EUtente(NULL, $username);
                        $modificaImpostazioni = $vImpostazioni->getTask2();
                        $vImpostazioni->modificaImpostazioniUtente($eUtente, $modificaImpostazioni);
                        break;

                    case 'clinica':
                        $vImpostazioni->visualizzaImpostazioniClinica();
                        break;

                    default:
                        break;
                }
            }   
            break;
        }
    }
    
    
    public function gestisciImpostazioniPOST()
    {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $task = $vImpostazioni->getTask();
        switch ($task) {
            case 'clinica':
                
                $task2 = $vImpostazioni->getTask2();
                echo ($task2);
                if($task2 === "workingPlan")
                {
//                
                    $workingPlanText = $vImpostazioni->recuperaWorkingPlan();
                    print_r($workingPlanText);
                    
                    $eClinica = new EClinica($username);
                    $salvato = $eClinica->salvaWorkingPlanClinica($workingPlanText);
                    if ($salvato === "TRUE")
                    {
                        echo "set salvato ";
                        //$vImpostazioni->setSalvato(TRUE);
                        $vImpostazioni->visualizzaImpostazioniClinica();
                    }                    
                }
                break;
                
            case 'modifica': // caso per modificare le impostazioni di un utente
                $task2 = $vImpostazioni->getTask2();
                switch ($task2) 
                {
                    case 'informazioni':
                        $dati = $vImpostazioni->recuperaInformazioni();
                        $uValidazione = USingleton::getInstance('UValidazione');
                        if($uValidazione->validaDati($dati))// se i dati sono validi
                            {           
                                $eUtente = new EUtente(NULL, $username);
                                if ($eUtente->modificaIndirizzoCAP($uValidazione->getDatiValidi())===TRUE)
                                {
                                    //modifiche effettuate
                                    $vJSON = USingleton::getInstance('VJSON');
                                    $vJSON->inviaDatiJSON(TRUE);
                                }
                                else
                                {
                                    $vJSON = USingleton::getInstance('VJSON');
                                    $vJSON->inviaDatiJSON(FALSE);
                                }
                            }
                            else
                            {    
                                // non tutti i dati sono validi 
                                $vJSON = USingleton::getInstance('VJSON');
                                $vJSON->inviaDatiJSON(FALSE);
                            }
                        break;
                    
                    case 'medico':
                        break;
                    
                    case 'credenziali':
                        $dati = $vImpostazioni->recuperaCredenziali();
                        $uValidazione = USingleton::getInstance('UValidazione');
                        if($uValidazione->validaDati($dati))// se i dati sono validi
                            {           
                                $eUtente = new EUtente(NULL, $username);
                                if ($eUtente->modificaPassword($uValidazione->getDatiValidi())===TRUE)
                                {
                                    //modifiche effettuate
                                    $vJSON = USingleton::getInstance('VJSON');
                                    $vJSON->inviaDatiJSON(TRUE);
                                }
                                else
                                {
                                    $vJSON = USingleton::getInstance('VJSON');
                                    $vJSON->inviaDatiJSON(FALSE);
                                }
                            }
                            else
                            {    
                                // non tutti i dati sono validi 
                                $vJSON = USingleton::getInstance('VJSON');
                                $vJSON->inviaDatiJSON(FALSE);
                            }
                        break;
                        break;
                    
                    default:
                        break;
                }

            default:
                break;
        }
    }

}
