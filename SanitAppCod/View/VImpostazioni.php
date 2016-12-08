<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VImpostazioni
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VImpostazioni extends View{
    
    
    /**
     * Metodo che consente di visualizzare le impostazioni dell'utente
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
     * Metodo che consente di visualizzare le impostazioni della clinica
     * @param array $workingPlan array contenente il workingPlan settimanale della clinica
     * @access public
     */
    public function visualizzaImpostazioniClinica($workingPlan)
    {  
       $giorni = Array("Lunedi", "Martedi", "Mercoledi", "Giovedi", "Venerdi", "Sabato", "Domenica");
       $this->assegnaVariabiliTemplate('workingPlan', $workingPlan);
       $this->assegnaVariabiliTemplate('giorniSettimanali', $giorni);
       $this->visualizzaTemplate('workingPlan'); 
    }
    
    /**
     * Metodo che consente di modificare le informazioni dell'utente
     * 
     * @access public
     * @param EUtente $utente Una entità utente
     * @return type Description
     */
    public function modificaImpostazioniUtente($utente, $modificaInformazioni)
    {  
        switch ($modificaInformazioni) 
        {
            case 'informazioni':
                echo "modifica informazioni";
                $this->assegnaVariabiliTemplate('informazioniGenerali', TRUE);
                $this->assegnaVariabiliTemplate('modificaInformazioni', TRUE );
                break;

            case 'medico':
                $this->assegnaVariabiliTemplate('medicoCurante', TRUE);
                $this->assegnaVariabiliTemplate('modificaMedicoCurante', TRUE );
                break;

            case 'credenziali':
                $this->assegnaVariabiliTemplate('credenziali', TRUE);
                $this->assegnaVariabiliTemplate('modificaCredenziali', TRUE );
                break;

            default:
                break;
        }
        $this->assegnaVariabiliTemplate('utente', $utente);
        $this->visualizzaTemplate('impostazioniUtente'); 
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
                $inizioFine = Array ('Start' => $_POST[$giorno . 'Start'] , 'End' => $_POST[$giorno . 'End'],
                                    'BreakStart' => $_POST[$giorno.'BreakStart'], 'BreakEnd' => $_POST[$giorno.'BreakEnd']);
//                if
//                $inizioFine['Pause'] = $_POST[$giorno . 'Pausa'];
                $workingPlan ["$giorno"]= $inizioFine; 
            }
            else
            {
                $workingPlan ["$giorno"]= NULL;
                
            }
           
        } 
        $workingPlan["tempoLimite"] = $_POST["tempoLimite"];
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
