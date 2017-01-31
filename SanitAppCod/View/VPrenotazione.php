<?php

/**
 * Description of VPrenotazione
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VPrenotazione extends View{
    
    /** credo che possa essere eliminato
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
     * Metodo che consente di restituire tutte le prenotazioni associate ad un user.
     * 
     * @access public
     * @param array $risultato Il risultato della ricerca delle prenotazioni
     */
    public function restituisciPaginaRisultatoPrenotazioni($tipoUser, $risultato=NULL) 
    {
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        $this->assegnaVariabiliTemplate('tipoUser', ucfirst($tipoUser));
        if(isset($risultato) && count($risultato)>0)
            {
                $this->assegnaVariabiliTemplate('prenotazioni', TRUE);                
                $this->assegnaVariabiliTemplate('prenotazioni', TRUE);
                $this->assegnaVariabiliTemplate('dati', $risultato);
            }
        $this->visualizzaTemplate('tabellaPrenotazioni');
    }
    
    /**
     * Metodo che consente di resituire la pagina per aggiungere una nuova prenotazione.
     * 
     * @access public
     * @param string $nomeEsame Il nome dell'esame che si vuole prenotare
     * @param string $nomeClinica Il nome della clinica presso cui si vuole prenotare
     * @param string $partitaIVAClinica La partita IVA della clinica presso cui si vuole prenotare
     * @param string $idEsame L'id dell'esame che si vuole prenotare
     * @param type $durataEsame La durata dell'esame
     * @param string $codiceFiscale Il codice fiscale dell'utente che deve effettuare la visita
     * @param string $tipoUser Il tipo di user che vuole modificare la prenotazione
     */
    public function restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $partitaIVAClinica, $idEsame, $durataEsame, $codiceFiscale=NULL, $tipoUser=NULL)
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
        if(isset($tipoUser))
        {
           $this->assegnaVariabiliTemplate('tipoUser', $tipoUser); 
        }
        $this->visualizzaTemplate('prenotazioneEsame');
    }
    
    /**
     * Metodo che contente di ottenere una campo di ricerca per gli utenti di Sanitapp.
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
    
    /**
     * Metodo che consente di visualizzare tutte le informazioni di una prenotazione
     * 
     * @access public
     * @param EPrenotazione $prenotazione La prenotazione di cui si vogliono visualizzare le informazioni
     * @param string $nomeUtente Il nome dell'utente che effettuerà la visita
     * @param string $cognomeUtente Il cognome dell'utente che effettuerà la visita
     * @param string $nomeEsame Il nome dell'esame prenotato
     * @param string $medicoEsame Il nome del medico che effettua la visita presso la clinica
     * @param string $tipoUser Il tipo di user
     * @param EClinica $eClinica La clinica presso cui si effettua la prenotazione
     * @param string $idReferto L'id del referto relativo alla prenotazione
     * @param string $nome Il nome di chi ha prenotato la visita
     * @param string $cognome Il cognome di chi ha prenotato la visita
     * @param boolean $cancellaPrenota TRUE se è possibile modificare o cambiare la prenotazione, FALSE altrimenti
     */
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
        $this->visualizzaTemplate('infoPrenotazione');
    }
}
