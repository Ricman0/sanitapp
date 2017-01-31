<?php

/**
 * Description of VImpostazioni
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VImpostazioni extends View{
    
    /**
     * Metodo che consente di visualizzare le impostazioni/informazioni del medico
     * 
     * @access public
     * @param EMedico $medico Una entità medico
     */
    public function visualizzaImpostazioniMedico($medico)
    {  
        $this->assegnaVariabiliTemplate('medico', $medico);
        $this->assegnaVariabiliTemplate('informazioniGenerali', TRUE);
        $this->assegnaVariabiliTemplate('credenziali', TRUE);
        $this->visualizzaTemplate('impostazioniMedico'); 
    }
    
    /**
     * Metodo che consente di visualizzare le impostazioni dell'utente.
     * 
     * @access public
     * @param EUtente $utente Una entità utente
     * @return type Description
     */
    public function visualizzaImpostazioniUtente($utente, $medico=NULL)
    {  
        $this->assegnaVariabiliTemplate('utente', $utente);
        $this->assegnaVariabiliTemplate('medico', $medico);
        $this->assegnaVariabiliTemplate('informazioniGenerali', TRUE);
        $this->assegnaVariabiliTemplate('medicoCurante', TRUE);
        $this->assegnaVariabiliTemplate('credenziali', TRUE);
        $this->visualizzaTemplate('impostazioniUtente'); 
    }
    
    /**
     * Metodo che consente di visualizzare le impostazioni della clinica.
     *
     * @access public 
     * @param EClinica $clinica La clinica di cui si vogliono visualizzare le impostazioni
     */
    public function visualizzaImpostazioniClinica($clinica, $informazioniGenerali=NULL, $credenziali=NULL ) {
        $this->assegnaVariabiliTemplate('clinica', $clinica);
        $this->assegnaVariabiliTemplate('informazioniGenerali', $informazioniGenerali);
        $this->assegnaVariabiliTemplate('credenziali', $credenziali);
        if(!isset($informazioniGenerali))
        {
            $this->assegnaVariabiliTemplate('modificaCredenziali', TRUE);
        }
        if(!isset($credenziali))
        {
            $this->assegnaVariabiliTemplate('modificaInformazioni', TRUE);
        }
        $this->visualizzaTemplate('impostazioniClinica'); 
    }
    
    /**
     * Metodo che consente di visualizzare il working plan della clinica.
     *
     * @access public 
     * @param array $workingPlan array contenente il workingPlan settimanale della clinica
     */
    public function visualizzaWorkingPlanClinica($workingPlan)
    {  
       $giorni = Array("Lunedi", "Martedi", "Mercoledi", "Giovedi", "Venerdi", "Sabato", "Domenica");
       $this->assegnaVariabiliTemplate('workingPlan', $workingPlan);
       $this->assegnaVariabiliTemplate('giorniSettimanali', $giorni);
       $this->visualizzaTemplate('workingPlan'); 
    }
    
    /**
     * Metodo che consente di ottenere la pagina per modificare le informazioni dell'user.
     * 
     * @access public
     * @param EUtente|EMedico $user Una entità user 
     * @param string $modificaInformazioni  la variabile smarty da modificare
     * @param string $tipoUser Il tipo di user dell'applicazione
     */
    public function modificaImpostazioni($user, $modificaInformazioni, $tipoUser)
    {  
        switch ($modificaInformazioni) 
        {
            case 'informazioni':
                $this->assegnaVariabiliTemplate('informazioniGenerali', TRUE);
                $this->assegnaVariabiliTemplate('modificaInformazioni', TRUE );
                break;

            case 'medico':
                $this->assegnaVariabiliTemplate('medicoCurante', TRUE);
                $this->assegnaVariabiliTemplate('modificaMedicoCurante', TRUE );
                break;
            case 'alboNum':
                $this->assegnaVariabiliTemplate('informazioniGenerali', TRUE);
                $this->assegnaVariabiliTemplate('modifica', TRUE );
                break;
            case 'credenziali':
                $this->assegnaVariabiliTemplate('credenziali', TRUE);
                $this->assegnaVariabiliTemplate('modificaCredenziali', TRUE );
                break;

            default:
                break;
        }
        if($tipoUser==='utente')
        {
            $this->assegnaVariabiliTemplate('utente', $user);
            $this->visualizzaTemplate('impostazioniUtente');
        }
        else
        {
            $this->assegnaVariabiliTemplate('medico', $user);
            $this->visualizzaTemplate('impostazioniMedico');
        }
        
    }
    
    
    
    /**
     *  Metodo che permette di conoscere il valore di task3 dell'URL
     * 
     * @access public
     * @final
     * @return mixed Ritorna il valore (stringa) di task3. False altrimenti.
     */
    public function getTask3() 
    {
        if (isset($_REQUEST['task3'])) 
            {
                return $_REQUEST['task3'];
            } 
        else 
            {
                return false;
            }
    }
    
    
//    public function recuperaWorkingPlan() 
//    {
//        $giorniSettimanali = Array("Lunedi", "Martedi", "Mercoledi", "Giovedi", "Venerdi", "Sabato", "Domenica");
//        $workingPlanText = "{";
//        foreach ($giorniSettimanali as $giorno) 
//        {
//            if (isset($_POST[$giorno]))
//            {
//               $workingPlanText .=  " " .  $giorno . " : {" .  $giorno . "Start : " . $_POST["$giorno" . "Start"] . ", " . $giorno . "End: " . $_POST["$giorno" . "End"] ;
//               if($giorno == "Domenica")
//                {
//                    $workingPlanText .= "}";
//                }
//                else 
//                {
//                    $workingPlanText .= " , ";
//                }
//            }
//            else
//            {
//                if($giorno==="Domenica")
//                {
//                    $workingPlanText .= $giorno . ": NULL}";
//                }
//                else 
//                {
//                    $workingPlanText .= $giorno . ": NULL, ";
//                }
//            }
//            
//        }
//
//        echo $workingPlanText;
//        return $workingPlanText;
//    }
    
    /**
     * Metodo che invia come risposta TRUE se il salvataggio è stato effettuato, FALSE altrimenti
     * 
     * @access public
     * @param boolean $salvato TRUE salvataggio effettuato
     * @return type Description
     */
    public function setSalvato($salvato) 
    {
        return $salvato;
    }
    
    
    /**
     * Metodo che consente di recuperare le impostazioni del working plan inserite
     * dalla clinica.
     * 
     * @access public
     * @return string Il working plan sottoforma di testo json
     */
    public function recuperaWorkingPlan() 
    {
        $giorniSettimanali = Array("Lunedi", "Martedi", "Mercoledi", "Giovedi", "Venerdi", "Sabato", "Domenica");
        $workingPlan = Array();
        foreach ($giorniSettimanali as $giorno) 
        {
            if (isset($_POST[$giorno]))
            {
                $inizioFine['Start'] = $this->recuperaValore($giorno . 'Start');
                $inizioFine['End'] = $this->recuperaValore($giorno . 'End');
                $inizioFine['BreakStart'] = $this->recuperaValore($giorno . 'BreakStart');
                $inizioFine['BreakEnd'] = $this->recuperaValore($giorno . 'BreakEnd');
                foreach ($inizioFine as $key => $value) {
                    if($value == FALSE)
                    {
                        unset($inizioFine[$key]); // eliminino dall'array l'elemento che ha valore FALSE
                    } 
                    
                }
//                if(isset($_POST[$giorno.'BreakStart']))
//                {
//                    $inizioFine = Array ('Start' => $_POST[$giorno . 'Start'] , 'End' => $_POST[$giorno . 'End'],
//                                    'BreakStart' => $_POST[$giorno.'BreakStart'], 'BreakEnd' => $_POST[$giorno.'BreakEnd']);
//                }
//                else 
//                {
//                    $inizioFine = Array ('Start' => $_POST[$giorno . 'Start'] , 'End' => $_POST[$giorno . 'End']);
//                }
                $workingPlan ["$giorno"]= $inizioFine; 
            }
            else
            {
                $workingPlan ["$giorno"]= NULL;
                
            }
           
        } 
//        $workingPlan["tempoLimite"] = $_POST["tempoLimite"];
        return json_encode($workingPlan);        
    }
    
    /**
     * Metodo che consente di recuperare tutti i dati relativi alle informazioni utente modificate
     * 
     * @access public
     * @return array I dati modificati che devono essere salvati nel DB
     */
    public function recuperaInformazioni() 
    {
        $dati = Array();
        $dati['Via'] = $this->recuperaValore('Via');
        $dati['NumCivico'] = $this->recuperaValore('NumCivico');
        $dati['CAP'] = $this->recuperaValore('CAP');
        if($this->recuperaValore('capitaleSociale')!==FALSE) // recupera le informazioni ulteriori per la clinica
        {
            $dati['capitaleSociale'] = $this->recuperaValore('capitaleSociale');
            $dati['telefono'] = $this->recuperaValore('telefono');
            $dati['localitàClinica'] = $this->recuperaValore('localitàClinica');
            $dati['provinciaClinica'] = $this->recuperaValore('provinciaClinica');
            $dati['titolare'] = $this->recuperaValore('titolare');
        }
        return $dati;
    }
    
    /**
     * Metodo che consente di recuperare tutti i dati relativi alle credenziali utente modificate
     * 
     * @access public
     * @return string La password modificata che deve essere salvata nel DB
     */
    function recuperaCredenziali() 
    {
        return $this->recuperaValore('password');
    }
    
    /**
     * Metodo che consente di recuperare il codice fiscale del nuovo medico
     * 
     * @access public
     * @return string Il codice fiscale del nuovo medico
     */
    function recuperaCFMedico() 
    {
        return $this->recuperaValore('codiceFiscale');
    }
}
