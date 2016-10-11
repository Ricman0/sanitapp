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
    public function visualizzaImpostazioniUtente($utente)
    {  
       $this->assegnaVariabiliTemplate('utente', $utente);
       return $this->visualizzaTemplate('impostazioniUtente'); 
    }
    
    /**
     * Metodo che consente di visualizzare le impostazioni della clinica
     * 
     * @access public
     * @param EClinica $clinica Una entità clinica
     * @return type Description
     */
    public function visualizzaImpostazioniClinica()
    {  
       $giorni = Array("Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica");
       $this->assegnaVariabiliTemplate('giorniSettimanali', $giorni);
       return $this->visualizzaTemplate('workingPlan'); 
    }
    
    /**
     * Metodo che consente di modificare le iformazioni dell'utente
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
                            $this->assegnaVariabiliTemplate('modificaInformazioni', "TRUE" );
                            break;
                        
                        case 'medico':
                            $this->assegnaVariabiliTemplate('modificaMedicoUtente', "TRUE" );
                            break;
                        
                        case 'credenziali':
                            $this->assegnaVariabiliTemplate('modificaInformazioni', "TRUE" );
                            break;

                        default:
                            break;
                    }
       
       $this->assegnaVariabiliTemplate('utente', $utente);
       return $this->visualizzaTemplate('impostazioniUtente'); 
    }
    
    /**
     *  Metodo che permette di conoscere il valore di task2 dell'URL
     * 
     * @access public
     * @final
     * @return mixed Ritorna il valore (stringa) di task2. False altrimenti.
     */
    public function getTask2() 
    {
        if (isset($_REQUEST['task2'])) 
            {
                return $_REQUEST['task2'];
            } 
        else 
            {
                return false;
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
    
    /**
     * Metodo che consente di recuperare le impostazioni del working plan inserite
     * dalla clinica.
     * 
     * @access public
     * @return string Il working plan sottoforma di testo
     */
    public function recuperaWorkingPlan() 
    {
        $workingPlanText = "{";
        
//        foreach ($_POST as $key => $value) 
//        {
//            if($key!=="controller")
//            {
//                $workingPlanText = "'" . $key . ":{'";
//            }
//        }
        
        if (isset($_POST['Lunedì']))
        {
           $workingPlanText .=  " Lunedì : {LunedìStart : " . $_POST['LunedìStart'] . ", LunedìEnd: " . $_POST['LunedìEnd'] . " , ";
           
        }
        else
        {
            $workingPlanText .= "Lunedì: NULL, ";
        }
        if (isset($_POST['Martedì']))
        {
           $workingPlanText .= " Martedì : {MartedìStart: " . $_POST['MartedìStart'] . ", MartedìEnd: " . $_POST['MartedìEnd'] . ", ";
        }
        else
        {
            $workingPlanText .=  "Martedì: NULL, ";
        } 
        if (isset($_POST['Mercoledì']))
        {
           $workingPlanText .= " Mercoledì: {MercoledìStart: " . $_POST['MercoledìStart'] . ", MercoledìEnd: " . $_POST['MercoledìEnd'] . ", ";
        }
        else
        {
            $workingPlanText .=  "Mercoledì:NULL, ";
        }
        if (isset($_POST['Giovedì']))
        {
           $workingPlanText .= " Giovedì: {GiovedìStart: " . $_POST['GiovedìStart'] . ", GiovedìEnd: " . $_POST['GiovedìEnd'] . ", ";
        }
        else
        {
            $workingPlanText .=  "Giovedì:NULL, ";
        }
        if (isset($_POST['Venerdì']))
        {
           $workingPlanText .= " Venerdì: {VenerdìStart: " . $_POST['VenerdìStart'] . ", VenerdìEnd: " . $_POST['VenerdìEnd'] . ", ";
        }
        else
        {
            $workingPlanText .=  "Venerdì:NULL, ";
        }
        if (isset($_POST['Sabato']))
        {
           $workingPlanText .= " Sabato: {SabatoStart: " . $_POST['SabatoStart'] . ", SabatoEnd: " . $_POST['SabatoEnd'] . ", ";
        }
        else
        {
            $workingPlanText .=  "Sabato:NULL, ";
        }
        if (isset($_POST['Domenica']))
        {
           $workingPlanText .= " Domenica: {DomenicaStart: " . $_POST['DomenicaStart'] . ", DomenicaEnd: " . $_POST['DomenicaEnd'] . "}";
        }
        else
        {
            $workingPlanText.=  "Domenica:NULL }";
        }
        echo $workingPlanText;
        return $workingPlanText;
    }
    
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
}
