<?php

/**
 * La classe VGestisciCategotie si occupa di visualizzare i template relativi alla gestione delle categorie.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciCategorie extends View {

    /**
     * Metodo che consente di visualizzare le categorie dell'applicazione.
     * 
     * @access public
     * @param array $categorieEsami Le categorie da visualizzare
     */
    public function visualizzaCategorie($categorieEsami) {

//        if (count($categorieEsami) > 0) {
            $this->assegnaVariabiliTemplate('dati', $categorieEsami);
            $this->visualizzaTemplate('tabellaCategorie');
//        } else {
//            $this->visualizzaFeedback('Non è stata impostata nessuna categoria');
//        }
    }

}
