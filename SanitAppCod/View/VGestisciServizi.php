<?php

/**
 * La classe VGestisciServizi si occupa di recuperare i dati e visualizzare i template relativi alla gestione dei servizi.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciServizi extends View{
    
    /**
     * Metodo che consente di ottenere la form per aggiungere un nuovo servizio/esame.
     * 
     * @access public
     * @param array $listaCategorie Tutte le categorie per gli esami/servizi presenti nell'applicazione
     * @param array $datiEsamiValidi I dati validi inseriti per aggiungere un nuovo esame
     */
    public function restituisciFormAggiungiServizi($listaCategorie, $datiEsamiValidi=NULL)
    {
        $this->assegnaVariabiliTemplate('categorie', $listaCategorie);
        $this->assegnaVariabiliTemplate('datiValidi', $datiEsamiValidi);
        $this->visualizzaTemplate('aggiungiEsame'); 
    }
    
    /**
     * Metodo che consente di visualizzare gli esami in una tabella.
     * 
     * @access public
     * @param array $risultato Gli esami da visualizzare
     */
    public function visualizzaEsami($risultato)
    {
        $this->assegnaVariabiliTemplate('dati', $risultato);
        $this->assegnaVariabiliTemplate('esami', TRUE);
        $this->assegnaVariabiliTemplate('controller', "servizi");
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        $this->visualizzaTemplate('tabellaEsami');
    }
    
    
    /**
     * Metodo che consente di visualizzare tutte le informazioni di un esame.
     * 
     * @access public
     * @param EEsame $esame L'esame di cui si vogliono visualizzare le informazioni
     * @param boolean $servizi TRUE se si vogliono visualizzare le informazioni di un servizio, altrimenti le informazioni di un esame.
     */
    public function visualizzaInfoEsame($esame, $servizi, $tipoUser = NULL) 
    {
        if (isset($tipoUser))
        {
            $this->assegnaVariabiliTemplate('tipoUser', $tipoUser);
        }
        $this->assegnaVariabiliTemplate('esame', $esame);
        $this->assegnaVariabiliTemplate('tipoUser', 'clinica');
        $this->assegnaVariabiliTemplate('servizi', $servizi);
        $this->visualizzaTemplate("infoEsame");
        
    }
    
    /**
     * Metodo che recupera i tutti i dati di un esame dalla form 
     * per poter inserire un nuovo easme. I dati vengono memorizzati
     * nell'array $datiEsame.
     * 
     * @access public
     * @return array I dati per memorizzare l'esame
     */
    public function recuperaDatiEsame()
    {
        //creo un array in cui inserirsco i valori recuperati
        //pb: secondo te è una stupidaggine fare così e poi aggiungo del tempo  inutile
       $datiEsame = Array();
       $datiEsame['nome'] = $this->recuperaValore('nomeEsame');
       $datiEsame['medico'] = $this->recuperaValore('medicoEsame'); 
       $datiEsame['categoria'] = $this->recuperaValore('categoriaEsame');
       $datiEsame['prezzo'] =$this->recuperaValore('prezzoEsame');
       $datiEsame['durata'] = $this->recuperaValore('durataEsame');
       $datiEsame['numPrestazioniSimultanee'] = $this->recuperaValore('numPrestazioniSimultanee');
       $datiEsame['descrizione'] = $this->recuperaValore('descrizioneEsame');
       return $datiEsame;
    }
}
