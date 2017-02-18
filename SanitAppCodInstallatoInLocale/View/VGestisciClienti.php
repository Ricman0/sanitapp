<?php

/**
 * La classe VGestisciClienti si occupa di visualizzare i template relativi alla gestione dei clienti.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciClienti extends View{

    /**
     * Metodo che permette di visualizzare tutti i clienti di una clinica.
     * 
     * @access public
     * @param array $risultato Un array di utenti pazienti di un medico
     */
    public function visualizzaClienti($risultato) 
    {
        $this->assegnaVariabiliTemplate('dati', $risultato);
        $this->visualizzaTemplate('tabellaClienti');
    }
    
    /**
     * Metodo che consente di visualizzare le informazioni di un utente.
     * 
     * @access public
     * @param EUtente $eUtente L'utente di cui si vogliono visualizzare le informazioni
     */
    public function visualizzaInfoUtente($eUtente) 
    {
        $this->assegnaVariabiliTemplate('utente', $eUtente);
        $this->visualizzaTemplate("infoUtente");
    }
}
