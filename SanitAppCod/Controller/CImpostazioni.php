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
    
    public function gestisciImpostazioni()
    {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $task = $vImpostazioni->getTask();
        switch ($task) {
            case 'utente':
                $eUtente = new EUtente();
              
                $task2 = $vImpostazioni->getTask2();
                echo ($task2);
                // per ora non metto isset ma solo se è = a modifica
                if ($task2 == "modifica")
                {
                    echo "modifica informazioni";
                    $modificaImpostazioni = $vImpostazioni->getTask3();
                    $vImpostazioni->modificaImpostazioniUtente($utente, $modificaInformazioni);
                    
                     
                }
                else
                {
                    $vImpostazioni->visualizzaImpostazioniUtente($eUtente);
                }
                break;
            
            case 'clinica':
//                $eClinica = new EClinica();
                
            {
                $vImpostazioni->visualizzaImpostazioniClinica();
            }

            default:
                break;
        }

    }

}
