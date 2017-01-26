<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VInformazioni
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VInformazioni extends View {

    /**
     * Visualizza la pagina delle informazioni
     * @param string $username Username dello user se esiste.
     * 
     */
    public function visualizzaInfo($username) {
        $messaggio = "<h4> La validazione del medico o della clinica avviene fornendo all'amministratore la <br>"
                . "documentazione necessaria a verificare la veridicità delle informazioni fornite "
                . "durante la registrazione.<br><br>"
                . "La clinica che vuole validarsi dovrà fornire l'autorizzazione sanitaria valida secondo <br>"
                . "l'articolo 193 del Testo Unico Leggi Sanitarie(TULLS) (R.D.1265/1934).<br><br> "
                . "Il medico che vuole validarsi dovrà fornire l'autorizzazione per "
                . "l'esercizio della professione sanitaria. <br><br>"
                . "Tutta la documentazione fornita dovra essere inviata all'amministratore tramite "
                . "l'utilizzo <br> di posta certificata oppure per via raccomandata. <br> Per le informazioni necessare "
                . "all'invio dei documenti fare riferimento alla sezione dei contatti.</h4>";
        if ($username) {
            $this->visualizzaFeedback($messaggio);
        } else {
            $this->visualizzaFeedback($messaggio, TRUE);
        }
    }

}