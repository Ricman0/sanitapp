<?php

/**
 * Description of VPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VPrenotazione extends View{
    public function restituisciPaginaRisultatoPrenotazioni($risultato)
    {
//        $this->prelevaTemplate('tabellaPrenotazioni');
        $this->assegnaVariabiliTemplate('dati', $risultato);
        return $this->visualizzaTemplate('tabellaPrenotazioni');
    }
}
