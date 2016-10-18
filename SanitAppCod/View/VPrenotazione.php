<?php

/**
 * Description of VPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VPrenotazione extends View{
    
    public function restituisciPaginaRiepilogoPrenotazione($eEsame, $eClinica, $eUtente, $data, $orario)
    {
        
        $this->assegnaVariabiliTemplate('utente', $eUtente);
        $this->assegnaVariabiliTemplate('orario', $orario);
        $this->assegnaVariabiliTemplate('data', $data);
        $this->assegnaVariabiliTemplate('clinica', $eClinica);
        $this->assegnaVariabiliTemplate('esame', $eEsame);
        return $this->visualizzaTemplate('riepilogoPrenotazione');
    }
    
    public function inviaDate($date) 
    {   
        echo $this->json_encode($date);
           
    }
    
    /**
     * Metodo che consente di recuperare l'orario dall'url
     */
    public function getOrario()
    {
        if (isset($_REQUEST['orario'])) 
            {
                return $_REQUEST['orario'];
            } 
        else 
            {
                return FALSE;
            }
    }
    
    public function getPartitaIVA()
    {
        if (isset($_REQUEST['clinica'])) 
            {
                return $_REQUEST['clinica'];
            } 
        else 
            {
                return FALSE;
            }
    }
    
    public function getGiorno() 
    {
        if (isset($_REQUEST['giorno'])) 
            {
                return $_REQUEST['giorno'];
            } 
        else 
            {
                return FALSE;
            }
    }
    
    public function getData() 
    {
        if (isset($_REQUEST['data'])) 
            {
                return $_REQUEST['data'];
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
    public function restituisciPaginaRisultatoPrenotazioni($risultato)
    {
//        $this->prelevaTemplate('tabellaPrenotazioni');
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        $this->assegnaVariabiliTemplate('dati', $risultato);
        return $this->visualizzaTemplate('tabellaPrenotazioni');
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
        return $this->visualizzaTemplate('prenotazioneEsame');
    }
}
