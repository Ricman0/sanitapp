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
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $task = $vImpostazioni->getTask();
        switch ($task) {
            case 'utente':
                
                $eUtente = new EUtente(NULL, $username);

                $task2 = $vImpostazioni->getTask2();
                echo ($task2);
                // per ora non metto isset ma solo se è = a modifica
                if ($task2 == "modifica") {
                    echo "modifica informazioni";
                    $modificaImpostazioni = $vImpostazioni->getTask3();
                    $vImpostazioni->modificaImpostazioniUtente($eUtente, $modificaImpostazioni);
                } else {
                    $vImpostazioni->visualizzaImpostazioniUtente($eUtente);
                }
                break;

            case 'clinica':
//                $eClinica = new EClinica();
                {
                    $vImpostazioni->visualizzaImpostazioniClinica();
                }
                break;

            default:
                break;
        }
    }
    
    
    public function gestisciImpostazioniPOST()
    {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
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
                    $sessione = USingleton::getInstance('USession');
                    $usernameClinica = $sessione->leggiVariabileSessione('usernameLogIn');
                    $eClinica = new EClinica($usernameClinica);
                    $salvato = $eClinica->salvaWorkingPlanClinica($workingPlanText);
                    if ($salvato === "TRUE")
                    {
                        echo "set salvato ";
                        //$vImpostazioni->setSalvato(TRUE);
                        $vImpostazioni->visualizzaImpostazioniClinica();
                    }                    
                }
                break;

            default:
                break;
        }
    }

}
