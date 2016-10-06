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
                $vImpostazioni->visualizzaImpostazioniUtente($eUtente);

                break;

            default:
                break;
        }

    }

}
