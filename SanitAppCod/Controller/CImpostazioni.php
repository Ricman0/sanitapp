<?php

/**
 * La classe CImpostazioni si occupa di gestire il controller 'impostazioni'.
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
                try {
                    $eClinica = new EClinica(NULL, $partitaIVAClinica);
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON($eClinica->getGiorniNonLavorativi());
                } catch (XClinicaException $ex) {
                    $vImpostazioni->visualizzaFeedback("C'è stato un errore. ");                    
                }
                catch (XDBException $ex) {
                    $vImpostazioni->visualizzaFeedback("C'è stato un errore. ");                    
                }
                break;

            case 'visualizza': // GET impostazioni/visualizza
                $this->visualizzaImpostazioni($tipoUser, $username);
                break;
            
            case 'workingPlan':
                $this->visualizzaWorkingPlan($username);
                break;
            
            case 'generali':
                $this->visualizzaImpostazioni($tipoUser, $username);
                break;

            case 'modifica': { // GET impostazioni/modifica
                    try {
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
                            $task2 = $vImpostazioni->getTask2();
                            $eClinica = new EClinica($username);
                            if($task2==='informazioni')
                            {
                                $vImpostazioni->visualizzaImpostazioniClinica($eClinica,TRUE);
                            }
                            else 
                            {
                                $vImpostazioni->visualizzaImpostazioniClinica($eClinica,NULL,TRUE);
                            }

                            
                            break;

                        default:
                            break;
                        }
                        
                    } catch (Exception $ex) {
                        
                    }
                    
                }
                break;
            case 'aggiungi':
                $task2 = $vImpostazioni->getTask2();
                if($task2 === 'medico')
                {
                    try {
                        $eUtente = new EUtente(NULL, $username);
                        $medici = $eUtente->cercaMedici();
                        $vJSON = USingleton::getInstance('VJSON');
                        $vJSON->inviaDatiJSON($medici);
                    } catch (XUtenteException $ex) {
                        $vJSON = USingleton::getInstance('VJSON');
                        $vJSON->inviaDatiJSON(FALSE);
                    }
                    catch (XDBException $ex) {
                        $vJSON = USingleton::getInstance('VJSON');
                        $vJSON->inviaDatiJSON(FALSE);
                    }
                    
                }
                else
                {
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON(FALSE);
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
                if ($task2 === "workingPlan") {
                    $workingPlanText = $vImpostazioni->recuperaWorkingPlan();
                    $workingPlanArray = json_decode($workingPlanText);
                    $uValidazione = USingleton::getInstance('UValidazione');
                    $uValidazione->validaWorkingPlan($workingPlanArray);
                    if($uValidazione->getValidati() )
                    {
                        try {
                            $eClinica = new EClinica($username);
                            $salvato = $eClinica->salvaWorkingPlanClinica($workingPlanText);
                            if ($salvato) {
                                $vImpostazioni->visualizzaFeedback('Working Plan salvato con successo');
                            }
                        } catch (XClinicaException $ex) {
                            $vImpostazioni->visualizzaFeedback("Clinica Inesistente. Working Plan non salvato.");
                        }
                        catch (XDBException $ex) {
                            $vImpostazioni->visualizzaFeedback("C'è stato un errore. Working Plan non salvato.");
                        }
                    }
                    else
                    {
                        $vImpostazioni->visualizzaFeedback("C'è stato un errore. Working Plan non salvato.");
                    }
                    
                }
                break;

            case 'aggiungi': // POST impostazioni/aggiungi
                $task2 = $vImpostazioni->getTask2();
                if($task2 === 'medico')
                {
                    try {
                        $codiceMedico['codiceFiscale'] = $vImpostazioni->recuperaValore('codice');
                        $uValidazione = USingleton::getInstance('UValidazione');
                        $uValidazione->validaDati($codiceMedico);
                        if($uValidazione->getValidati()===TRUE)
                        {
                            $eUtente = new EUtente(NULL, $username);
                            $eUtente->aggiungiMedicoCurante($codiceMedico);
                            $eMedico = new EMedico($codiceMedico);
                            $vImpostazioni->visualizzaImpostazioniUtente($eUtente, $eMedico);
                        }
                        else
                        {
                            $vJSON = USingleton::getInstance('VJSON');
                            $vJSON->inviaDatiJSON(FALSE);
                        }
                        
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
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON(FALSE);
                }
                break;
            
            case 'modifica': // POST impostazioni/modifica
// caso per modificare le impostazioni di un utente
                $task2 = $vImpostazioni->getTask2();
                switch ($task2) {
                    case 'informazioni':
                        $this->modificaInformazioni($username);
                        break;

                    case 'medico':// POST impostazioni/modifica/medico
                        $this->modificaMedicoCurante($username);
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
    
    /**
     * Metodo che consente di modificare le informazioni di un user.
     * 
     * @access public
     * @param string $username L'username dello user di cui si vogliono modificare le informazioni
     */
    public function modificaInformazioni($username) {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $session = USingleton::getInstance('USession');
        $tipoUser = $session->leggiVariabileSessione('tipoUser');
        $dati = $vImpostazioni->recuperaInformazioni();
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($dati)) {// se i dati sono validi
            try {
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
                elseif($tipoUser==='medico')
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
                else
                {
                    $eClinica = new EClinica($username);
                    $modificato = $eClinica->modificaClinica($uValidazione->getDatiValidi());
                    if($modificato === TRUE)
                    {
                        $vImpostazioni->visualizzaImpostazioniClinica($eClinica, TRUE, TRUE);
                    }
                    else
                    {
        //                    $vImpostazioni->visualizzaFeedback("C'è stato un errore non è stato possibile modificare le informazioni");
                        $vJSON = USingleton::getInstance('VJSON');
                        $vJSON->inviaDatiJSON(FALSE);

                    }
                }
            } 
            catch (XUtenteException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
            catch (XMedicoException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
            catch (XClinicaException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }
            catch (XDBException $ex) {
                $vJSON = USingleton::getInstance('VJSON');
                $vJSON->inviaDatiJSON(FALSE);
            }    
        } else {
            // non tutti i dati sono validi 
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON(FALSE);
        }
    }

    /**
     * Metodo che consente ad un utente di modificare il proprio medico curante.
     * 
     * @access public
     * @param string $username L'username dell'utente
     */
    public function modificaMedicoCurante($username) {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        $dati = $vImpostazioni->recuperaCFMedico();
        $arrayDati['codiceFiscale'] = $dati;
        $uValidazione = USingleton::getInstance('UValidazione');
        if ($uValidazione->validaDati($arrayDati)) {// se i dati sono validi
            try {
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
                } 
                else {
                    $vJSON = USingleton::getInstance('VJSON');
                    $vJSON->inviaDatiJSON(FALSE);
                }
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

        } else {
            // non tutti i dati sono validi 
            $vJSON = USingleton::getInstance('VJSON');
            $vJSON->inviaDatiJSON(FALSE);
        }
    }

    /**
     * Metodo che consente di modificare la provincia dell'albo a cui un medico è iscritto e il numero di iscrizione.
     * 
     * @access public
     */
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
                        elseif($tipoUser==='medico')
                        {
                            $eMedico = new EMedico(NULL, $username);
                            $vImpostazioni->visualizzaImpostazioniMedico($eMedico);

                        }
                        else
                        {
                            $eClinica = new EClinica($username);
                            $vImpostazioni->visualizzaImpostazioniClinica($eClinica, TRUE, TRUE);
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
            catch (XClinicaException $ex) {
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
                try {
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
                } 
                catch (XUtenteException $ex) {
                    $messaggio = $ex->getMessage();
                    $vImpostazioni->visualizzaFeedback($messaggio);
                }
                catch (XMedicoException $ex) {
                    $messaggio = $ex->getMessage();
                    $vImpostazioni->visualizzaFeedback($messaggio);
                }
                catch (XDBException $ex) {
                    $vImpostazioni->visualizzaFeedback("C'è stato un errore. Non è stato possibile recuperare il working plan della clinica. ");
                }
                break;

            case 'medico':
                try {
                    $eMedico = new EMedico(NULL, $username);
                    $vImpostazioni->visualizzaImpostazioniMedico($eMedico);
                } 
                catch (XMedicoException $ex) {
                    $messaggio = $ex->getMessage();
                    $vImpostazioni->visualizzaFeedback($messaggio);
                }
                catch (XDBException $ex) {
                    $vImpostazioni->visualizzaFeedback("C'è stato un errore. Non è stato possibile recuperare il working plan della clinica. ");
                }
                break;

            case 'clinica': 
                try {
                    $eClinica = new EClinica($username);
                    $vImpostazioni->visualizzaImpostazioniClinica($eClinica, TRUE, TRUE);
                } 
                catch (XClinicaException $ex) {
                    $messaggio = $ex->getMessage();
                    $vImpostazioni->visualizzaFeedback($messaggio);
                }
                catch (XDBException $ex) {
                    $vImpostazioni->visualizzaFeedback("C'è stato un errore. Non è stato possibile recuperare il working plan della clinica. ");
                }
                break;

            default:
                break;
            } 
    }
    
    /**
     * Metodo che consente di visualizzare il working plan di una clinica dell'applicazione.
     * 
     * @access public
     * @param string $username L'username dell'user dell'applicazione che vuole visualizzare il suo working plan
     */
    public function visualizzaWorkingPlan($username) {
        $vImpostazioni = USingleton::getInstance('VImpostazioni');
        try {
            $eClinica = new EClinica($username);
            $vImpostazioni->visualizzaWorkingPlanClinica($eClinica->getArrayWorkingPlanClinica());
        } 
        catch (XClinicaException $ex) {
            $messaggio = $ex->getMessage();
            $vImpostazioni->visualizzaFeedback($messaggio);
        }
        catch (XDBException $ex) {
            $vImpostazioni->visualizzaFeedback("C'è stato un errore. Non è stato possibile recuperare il working plan della clinica. ");
        }
            
                
    }
}
