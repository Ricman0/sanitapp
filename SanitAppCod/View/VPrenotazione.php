<?php

/**
 * Description of VPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VPrenotazione extends View{
    
    public function appuntamentoAggiunto($risultato) 
    {
        $this->assegnaVariabiliTemplate('risultato', $risultato);
        $this->visualizzaTemplate('prenotazioneAggiunta');
    }
    public function restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario, $codice)
    {
        $this->assegnaVariabiliTemplate('codice', $codice);
        $this->assegnaVariabiliTemplate('utente', $eUtente);
        $this->assegnaVariabiliTemplate('orario', $orario);
        $this->assegnaVariabiliTemplate('data', $data);
        $this->assegnaVariabiliTemplate('clinica', $eClinica);
        $this->assegnaVariabiliTemplate('esame', $eEsame);
        $this->visualizzaTemplate('riepilogoPrenotazione');
    }
    
    public function inviaDate($date) 
    {   
        echo $this->json_encode($date);  
    }
    

    

    
    
    
    /**
     * Metodo che consente di restituire tutte le prenotazioni associate ad un utente
     * 
     * @access public
     * @param Array $risultato Il risultato della ricerca delle prenotazioni di un utente
     */
    public function restituisciPaginaRisultatoPrenotazioni($risultato, $tipoUser) 
    {
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        if(count($risultato)>0)
            {
                $this->assegnaVariabiliTemplate('tipoUser', ucfirst($tipoUser));
                $this->assegnaVariabiliTemplate('prenotazioni', TRUE);
                $this->assegnaVariabiliTemplate('dati', $risultato);
            }
        $this->visualizzaTemplate('tabellaPrenotazioni');
    }
    
    /**
     * Metodo che consente di resituire la form per aggiungere una nuova prenotazione
     * 
     * @access public
     */
    public function restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $idEsame)
    {
        $this->assegnaVariabiliTemplate('nomeClinica', $nomeClinica);
        $this->assegnaVariabiliTemplate('nomeEsame', $nomeEsame);
        $this->assegnaVariabiliTemplate('idEsame', $idEsame);
        $this->assegnaVariabiliTemplate('partitaIVA', $partitaIVAClinica);
        $this->visualizzaTemplate('prenotazioneEsame');
    }
    
    /**
     * Metodo che contente di ottenere una campo di ricerca per gli utenti di Sanitapp
     * 
     * @access public
     * @param string $nomeClinica Il nome della clinica
     * @param string $tipoUser Il tipo di user
     */
    public function impostaPaginaCercaUtente($nomeClinica, $tipoUser) 
    {
        $this->assegnaVariabiliTemplate('tipoUser', $tipoUser);
        $this->assegnaVariabiliTemplate('nomeClinica', $nomeClinica);
        $this->visualizzaTemplate('cercaUtente');
    }
    
    public function visualizzaInfoPrenotazione($prenotazione, $nomeUtente, $cognomeUtente, $nomeEsame, $medicoEsame, $tipoUser, $eClinica, $idReferto=NULL, $nome, $cognome) 
    {
        $this->assegnaVariabiliTemplate('prenotazione', $prenotazione);        
        $this->assegnaVariabiliTemplate('tipoUser', $tipoUser);
        $this->assegnaVariabiliTemplate('nomeUtente', $nomeUtente);
        $this->assegnaVariabiliTemplate('eClinica', $eClinica);
        $this->assegnaVariabiliTemplate('idReferto', $idReferto);
        $this->assegnaVariabiliTemplate('cognomeUtente', $cognomeUtente);
        $this->assegnaVariabiliTemplate('nomeEsame', $nomeEsame);
        $this->assegnaVariabiliTemplate('medicoEsame', $medicoEsame);
        $this->assegnaVariabiliTemplate('nome', $nome);
        $this->assegnaVariabiliTemplate('cognome', $cognome);
        $this->visualizzaTemplate("infoPrenotazione");
        
    }
}
