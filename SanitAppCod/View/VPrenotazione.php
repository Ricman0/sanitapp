<?php

/**
 * Description of VPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VPrenotazione extends View{
    
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
    public function restituisciPaginaAggiungiPrenotazione($nomeEsame, $nomeClinica, $workingPlan, $prenotazioni)
    {
        $this->assegnaVariabiliTemplate('nomeClinica', $nomeClinica);
        $this->assegnaVariabiliTemplate('nomeEsame', $nomeEsame);
        $this->assegnaVariabiliTemplate('workingPlan', $workingPlan);
        $this->assegnaVariabiliTemplate('prenotazioni', $prenotazioni);
        return $this->visualizzaTemplate('prenotaEsame');
    }
}
