<?php

/**
 * Description of VPrenotazione
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VPrenotazione extends View{
    
    /**
     * Metodo che consente di visualizzare se la prenotazione è stata o meno eliminata
     * 
     * @param boolean $eliminata TRUE la prenotazione è stata eliminata dal DB, FALSE altrimenti
     */
    public function prenotazioneEliminata($eliminata, $mailInviata=FALSE) 
    {
        $this->assegnaVariabiliTemplate('prenotazioneEliminata', $eliminata);
        $this->assegnaVariabiliTemplate('mailInviata', $mailInviata);
        $this->visualizzaTemplate('prenotazioneEliminata');
    }
    
    public function restituisciPaginaRiepilogoPrenotazione($errore, $eEsame=NULL, $eClinica=NULL, $eUtente=NULL, $data=NULL, $orario=NULL, $codice=NULL, $modifica=FALSE, $idPrenotazione=NULL)
    {
        
        if(!isset($errore))
        {
            $this->assegnaVariabiliTemplate('codice', $codice);
            $this->assegnaVariabiliTemplate('utente', $eUtente);
            $this->assegnaVariabiliTemplate('orario', $orario);
            $this->assegnaVariabiliTemplate('data', $data);
            $this->assegnaVariabiliTemplate('clinica', $eClinica);
            $this->assegnaVariabiliTemplate('esame', $eEsame);  
            $this->assegnaVariabiliTemplate('modifica', $modifica);
            if(isset($idPrenotazione))
            { 
                $this->assegnaVariabiliTemplate('idPrenotazione', $idPrenotazione);
            }
        }
        else 
        {
            $this->assegnaVariabiliTemplate('messaggio', $errore);
            $feedbackTpl = $this->prelevaTemplate('feedbacks');
            $this->assegnaVariabiliTemplate('feedbacks', $feedbackTpl);
            
        }
        
        $this->visualizzaTemplate('riepilogoPrenotazione');
    }
    
    public function inviaDate($date) 
    {   
        echo $this->json_encode($date);  
    }
    

    public function getAzione() 
    {
        echo "ss";
        if (isset($_REQUEST['azione'])) 
        {
            echo "2";
            return $_REQUEST['azione'];
        }
        else 
        {
            return FALSE;
        }
    }

    
    
    
    /**
     * Metodo che consente di restituire tutte le prenotazioni associate ad un utente
     * 
     * @access public
     * @param Array $risultato Il risultato della ricerca delle prenotazioni di un utente
     */
    public function restituisciPaginaRisultatoPrenotazioni($tipoUser, $risultato=NULL, $errore=NULL) 
    {
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        $this->assegnaVariabiliTemplate('tipoUser', ucfirst($tipoUser));
        if(isset($risultato) && count($risultato)>0)
            {
                $this->assegnaVariabiliTemplate('prenotazioni', TRUE);                
                $this->assegnaVariabiliTemplate('prenotazioni', TRUE);
                $this->assegnaVariabiliTemplate('dati', $risultato);
            }
        if(isset($errore))
            {
                $this->assegnaVariabiliTemplate('errore', $errore);
            }
        $this->visualizzaTemplate('tabellaPrenotazioni');
    }
    
    /**
     * Metodo che consente di resituire la form per aggiungere una nuova prenotazione
     * 
     * @access public
     */
    public function restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $idEsame, $durataEsame, $codiceFiscale=NULL)
    {
        $this->assegnaVariabiliTemplate('nomeClinica', $nomeClinica);
        $this->assegnaVariabiliTemplate('nomeEsame', $nomeEsame);
        $this->assegnaVariabiliTemplate('idEsame', $idEsame);
        $this->assegnaVariabiliTemplate('durataEsame', $durataEsame);
        $this->assegnaVariabiliTemplate('partitaIVA', $partitaIVAClinica);
        if(isset($codiceFiscale))
        {
           $this->assegnaVariabiliTemplate('codiceFiscale', $codiceFiscale); 
        }
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
    
    public function visualizzaInfoPrenotazione($prenotazione, $nomeUtente, $cognomeUtente, $nomeEsame, $medicoEsame, $tipoUser, $eClinica, $idReferto=NULL, $nome, $cognome, $cancellaPrenota) 
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
        $this->assegnaVariabiliTemplate('cancellaPrenota',$cancellaPrenota);
        $this->visualizzaTemplate("infoPrenotazione");
        
    }
}
