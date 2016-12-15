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
        switch ($task) {
            case 'giorniNonLavorativi':
                $partitaIVAClinica = $vImpostazioni->recuperaValore('clinica');
                $eClinica = new EClinica(NULL, $partitaIVAClinica);
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON($eClinica->getGiorniNonLavorativi());
                break;

            case 'visualizza': {
                    switch ($tipoUser) {
                        case 'utente':
                            $eUtente = new EUtente(NULL, $username);
                            $CFMedicoCurante = $eUtente->getMedicoCurante();
                            if (isset($CFMedicoCurante)) {
                                $eMedico = new EMedico($CFMedicoCurante);
                            }
                            $vImpostazioni->visualizzaImpostazioniUtente($eUtente, $eMedico);
                            break;

                        case 'medico':
                            $eMedico = new EMedico(NULL, $username);
                            $vImpostazioni->visualizzaImpostazioniMedico($eMedico);
                            break;
                            
                        case 'clinica': {
                                $eClinica = new EClinica($username);
                                $vImpostazioni->visualizzaImpostazioniClinica($eClinica->getWorkingPlanClinica());
                            }
                            break;

                        default:
                            break;
                    }
                }
                break;

            case 'modifica': {
                    switch ($tipoUser) {
                        case 'utente':
                            $eUtente = new EUtente(NULL, $username);
                            $modificaImpostazioni = $vImpostazioni->getTask2();
                            $vImpostazioni->modificaImpostazioni($eUtente, $modificaImpostazioni, 'utente');
                            break;
                        
                        case 'medico':
                            $eMedico = new EMedico(NULL, $username);
                            $modificaImpostazioni = $vImpostazioni->getTask2();
                            $vImpostazioni->modificaImpostazioni($eMedico, $modificaImpostazioni, 'medico');
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

    public function gestisciImpostazioniPOST() {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $sessione = USingleton::getInstance('USession');
        $username = $sessione->leggiVariabileSessione('usernameLogIn');
        $task = $vImpostazioni->getTask();
        switch ($task) {
            case 'clinica':

                $task2 = $vImpostazioni->getTask2();
                echo ($task2);
                if ($task2 === "workingPlan") {
//                
                    $workingPlanText = $vImpostazioni->recuperaWorkingPlan();
                    print_r($workingPlanText);

                    $eClinica = new EClinica($username);
                    $salvato = $eClinica->salvaWorkingPlanClinica($workingPlanText);
                    if ($salvato === "TRUE") {
                        echo "set salvato ";
                        //$vImpostazioni->setSalvato(TRUE);
                        $vImpostazioni->visualizzaImpostazioniClinica();
                    }
                }
                break;

            case 'modifica': // caso per modificare le impostazioni di un utente
                $task2 = $vImpostazioni->getTask2();
                switch ($task2) {
                    case 'informazioni':
                        $this->modificaInformazioni($vImpostazioni, $username);
                        break;

                    case 'medico':
                        $this->modificaMedicoCurante($vImpostazioni, $username);
                        break;
                    
                    case 'alboNum':
                        $this->modificaAlboNum($vImpostazioni, $username);
                        break;

                    case 'credenziali':
                        $this->modificaCredenziali($vImpostazioni, $username);
                        break;

                    default:
                        break;
                }

            default:
                break;
        }
    }

    public function modificaInformazioni($vImpostazioni, $username) {
        $session = USingleton::getInstance('USession');
        $tipoUser = $session->leggiVariabileSessione('tipoUser');
        $dati = $vImpostazioni->recuperaInformazioni();
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($dati)) {// se i dati sono validi
            if($tipoUser==='utente') 
            {//tipoUser=utente
                $eUtente = new EUtente(NULL, $username);
                if ($eUtente->modificaIndirizzoCAP($uValidazione->getDatiValidi()) === TRUE) {
                    //modifiche effettuate
    //                                    $vJSON = USingleton::getInstance('VJSON');
    //                                    $vJSON->inviaDatiJSON(TRUE);
                    $CFMedicoCurante = $eUtente->getMedicoCurante();
                    if (isset($CFMedicoCurante)) {
                        $eMedico = new EMedico($CFMedicoCurante);
                    }
                    $vImpostazioni->visualizzaImpostazioniUtente($eUtente, $eMedico);
                } 
                else {
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON(FALSE);
                }
            }
            else
            {
                //tipouser medico
                $eMedico = new EMedico(NULL, $username);
                $modificato = $eMedico->modificaIndirizzoCAP($uValidazione->getDatiValidi());
                if($modificato === TRUE)
                {
                    $vImpostazioni->visualizzaImpostazioniMedico($eMedico);
                }
                else
                {
//                    $vImpostazioni->visualizzaFeedback("C'è stato un errore non è stato possibile modificare le informazioni");
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON(FALSE);
                    
                }
            }
        } else {
            // non tutti i dati sono validi 
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON(FALSE);
        }
    }

    public function modificaMedicoCurante($vImpostazioni, $username) {

        $dati = $vImpostazioni->recuperaCFMedico();
        $arrayDati['codiceFiscale'] = $dati;
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($arrayDati)) {// se i dati sono validi
            $eUtente = new EUtente(NULL, $username);
            if ($eUtente->modificaMedicoCurante($uValidazione->getDatiValidi()['codiceFiscale']) === TRUE) {
                //modifiche effettuate
                $CFMedicoCurante = $eUtente->getMedicoCurante();
                if (isset($CFMedicoCurante)) {
                    $eMedico = new EMedico($CFMedicoCurante);
                }
                $vImpostazioni->visualizzaImpostazioniUtente($eUtente, $eMedico);
//                                $vJSON = USingleton::getInstance('VJSON');
//                                $vJSON->inviaDatiJSON(TRUE);
            } else {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
        } else {
            // non tutti i dati sono validi 
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON(FALSE);
        }
    }

    public function modificaCredenziali($vImpostazioni, $username) {
        $session = USingleton::getInstance('USession');
        $tipoUser = $session->leggiVariabileSessione('tipoUser');
        $dati = $vImpostazioni->recuperaCredenziali();
        $arrayDati['password'] = $dati;
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($arrayDati)) {// se i dati sono validi
            
                $eUser = new EUser($username);
                if ($eUser->modificaPassword($uValidazione->getDatiValidi()['password']) === TRUE) {
                    //modifiche effettuate
                    if($tipoUser==='utente')
                    {
                        $eUtente = new EUtente(NULL, $username);
                        $CFMedicoCurante = $eUtente->getMedicoCurante();
                        if (isset($CFMedicoCurante)) {
                            $eMedico = new EMedico($CFMedicoCurante);
                        }
                        $vImpostazioni->visualizzaImpostazioniUtente($eUtente, $eMedico);
        //                                $vJSON = USingleton::getInstance('VJSON');
        //                              $vJSON->inviaDatiJSON(TRUE);
                    }
                    else
                    {
                        $eMedico = new EMedico(NULL, $username);
                        $vImpostazioni->visualizzaImpostazioniMedico($eMedico);
                        
                    }
                } 
                else {
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON(FALSE);
                }
                
        } 
        else {
            // non tutti i dati sono validi 
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON(FALSE);
        }
    }

}
