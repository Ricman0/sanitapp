<?php

/**
 * Description of VPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VPrenotazione extends View{
    
    public function inviaDate($date) 
    {   
        $this->assegnaVariabiliTemplate('orariDisponibili', $date);
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
