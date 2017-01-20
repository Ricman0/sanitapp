<?php

/**
 * Description of CImpostazioni
 *
 * @package Controller
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CImpostazioni {

    /**
     * Metodo che consente di gestire le azioni del controller 'impostazioni' per le richieste GET HTTP.
     * 
     * @access public
     */
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

            case 'visualizza': // GET impostazioni/visualizza
                $this->visualizzaImpostazioni($tipoUser, $username);
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

    /**
     * Metodo che consente di gestire le azioni del controller 'impostazioni' per le richieste POST HTTP.
     * 
     * @access public
     */
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
                        $this->modificaAlboNum();
                        break;

                    case 'credenziali':
                        $this->modificaCredenziali($username);
                        break;

                    default:
                        break;
                }

            default:
                break;
        }
    }

    public function modificaInformazioni($username) {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
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
                    $CFMedicoCurante = $eUtente->getCodFiscaleMedicoUtente();
                    if (isset($CFMedicoCurante)) {
                        $eMedico = new EMedico($CFMedicoCurante);
                        $vImpostazioni->visualizzaImpostazioniUtente($eUtente, $eMedico);
                    }
                    else
                    {
                        $vImpostazioni->visualizzaImpostazioniUtente($eUtente, NULL);
                    }
                    
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
                $CFMedicoCurante = $eUtente->getCodFiscaleMedicoUtente();
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

    
    public function modificaAlboNum() {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $session = USingleton::getInstance('USession');
        $username = $session->leggiVariabileSessione('usernameLogIn');
        $provincia = $vImpostazioni->recuperaValore('provinciaAlbo');
        $numIscrizione = $vImpostazioni->recuperaValore('numeroIscrizione');
        $dati = Array('provinciaAlbo'=>$provincia, 'numeroIscrizione'=>$numIscrizione);
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($dati)) {// se i dati sono validi
            try {
                $eMedico = new EMedico(NULL, $username);
                if($eMedico->modificaProvAlboENumIscrizione($provincia, $numIscrizione)===TRUE)
                {
                    // visualizza la modifica nel tpl
                    $vImpostazioni->visualizzaImpostazioniMedico($eMedico);
                }
//                else {
//                        $vJSON = USingleton::getInstance('VJSON');
//                        $vJSON->inviaDatiJSON(FALSE);
//                    } 
            } 
            catch (XDBException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
            catch (XMedicoException $ex) {
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
    
    /**
     * Metodo che consente di modificare le credenziali di un user gestendo le eventuali eccezioni.
     * 
     * @access public
     * @param string $username L'username dello user di cui si vogliono modificare le credenziali
     */
    public function modificaCredenziali($username) {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $session = USingleton::getInstance('USession');
        $tipoUser = $session->leggiVariabileSessione('tipoUser');
        $dati = $vImpostazioni->recuperaCredenziali();
        $arrayDati['password'] = $dati;
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($arrayDati)) {// se i dati sono validi
            try {
                    $eUser = new EUser($username);
                    if ($eUser->modificaPassword($eUser->getUsernameUser(), $uValidazione->getDatiValidi()['password']) === TRUE) {
                    if($eUser->modificaPassword( $arrayDati['password']))
                    {
                        //modifiche effettuate
                        if($tipoUser==='utente')
                        {
                            $eUtente = new EUtente(NULL, $username);
                            $CFMedicoCurante = $eUtente->getCodFiscaleMedicoUtente();
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
            } catch (XUserException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
            catch (XUtenteException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
            catch (XMedicoException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
            catch (XDBException $ex) {
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

    /**
     * Metodo che consente di visualizzare le impostazioni di un user dell'applicazione.
     * 
     * @access public
     * @param string $tipoUser Il tipo di user di cui si vogliono visualizzare le impostazioni
     * @param string $username L'username dell'user dell'applicazione che vuole visualizzare le sue impostazioni
     */
    public function visualizzaImpostazioni($tipoUser, $username) {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        switch ($tipoUser) {
            case 'utente':
                $eUtente = new EUtente(NULL, $username);
                $CFMedicoCurante = $eUtente->getCodFiscaleMedicoUtente();
                if (isset($CFMedicoCurante)) {
                    $eMedico = new EMedico($CFMedicoCurante);
                    $vImpostazioni->visualizzaImpostazioniUtente($eUtente, $eMedico);
                }
                else
                {
                    $vImpostazioni->visualizzaImpostazioniUtente($eUtente, NULL);
                }
                break;

            case 'medico':
                $eMedico = new EMedico(NULL, $username);
                $vImpostazioni->visualizzaImpostazioniMedico($eMedico);
                break;

            case 'clinica': {
                    $eClinica = new EClinica($username);
                    $vImpostazioni->visualizzaImpostazioniClinica($eClinica->getArrayWorkingPlanClinica());
                }
                break;

            default:
                break;
            } 
    }
}
