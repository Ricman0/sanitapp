<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VmySanitApp
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VmySanitApp extends View {
    
    /**
     * Metodo che consente di impostare la giusta area personale a seconda del tipo 
     * di user già autenticato.
     * 
     * @access public
     * @param string $tipoUser Il tipo di user di cui si vuole impostare la pagin personale
     */
    public function impostaPaginaPersonale($tipoUser)
    {
        switch($tipoUser)
        {
            case 'clinica':
                $tastiLaterali['agendaAreaPersonaleClinica'] = "Agenda";
                $tastiLaterali['serviziAreaPersonaleClinica'] = "Servizi";
                $tastiLaterali['prenotazioniAreaPersonaleClinica'] = "Prenotazioni";
                $tastiLaterali['refertiAreaPersonaleClinica'] = "Referti";
                $tastiLaterali['clientiAreaPersonaleClinica'] = "Clienti";
                $tastiLaterali['impostazioniAreaPersonaleClinica'] = "Impostazioni";
                break;
            
            case 'medico':
                $tastiLaterali['pazientiAreaPersonaleMedico'] = "Pazienti";
                $tastiLaterali['prenotazioniAreaPersonaleMedico'] = "Prenotazioni";
                $tastiLaterali['refertiAreaPersonaleMedico'] = "Referti";
                $tastiLaterali['impostazioniAreaPersonaleMedico'] = "Impostazioni";
                 
                break;
            
            case 'utente':                
                $tastiLaterali['prenotazioniAreaPersonaleUtente'] = "Prenotazioni";
                $tastiLaterali['refertiAreaPersonaleUtente'] = "Referti";
                $tastiLaterali['impostazioniAreaPersonaleUtente'] = "Impostazioni";
                break;
            
            case 'amministratore':                
                $tastiLaterali['usersAreaPersonaleAmministratore'] = "Users";
                $tastiLaterali['bloccatiAreaPersonaleAmministratore'] = "Users Bloccati";
                $tastiLaterali['daValidareAreaPersonaleAmministratore'] = "Users da Validare";
                break;
            
            default: 
                $messaggio ="C'è stato un errore.";
                $this->visualizzaFeedback($messaggio, TRUE);// da controllare 
                break;
        }
        //prelevo  i template
        $areaPersonale = $this->prelevaTemplate("areaPersonaleGenerale");
        //assegno le variabili ai template
        $this->assegnaVariabiliTemplate("tastiLaterali", $tastiLaterali);
        $this->assegnaVariabiliTemplate("areaPersonale", $areaPersonale);
        // visualizzo il template 
        $this->visualizzaTemplate('areaPersonaleGenerale');
    }
}
