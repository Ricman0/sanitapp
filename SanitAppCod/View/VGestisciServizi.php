<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VGestisciServizi
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciServizi extends View{
    
    public function restituisciFormAggiungiServizi($listaCategorie)
    {
        $this->assegnaVariabiliTemplate('categorie', $listaCategorie);
        return $this->visualizzaTemplate('aggiungiEsame'); 
    }
    
    public function visualizzaEsami($risultato)
    {
        $this->assegnaVariabiliTemplate('dati', $risultato);
        $this->assegnaVariabiliTemplate('esami', TRUE);
        $this->assegnaVariabiliTemplate('controller', "servizi");
        $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        return $this->visualizzaTemplate('tabellaEsami');
    }
    
    
    public function visualizzaInfoEsame($esame, $servizi) 
    {
        $this->assegnaVariabiliTemplate('esame', $esame);
        $this->assegnaVariabiliTemplate('servizi', $servizi);
        $this->visualizzaTemplate("infoEsame");
        
    }
    
    /**
     * Metodo che recupera i tutti i dati di un esame dalla form 
     * per poter inserire un nuovo easme. I dati vengono memorizzati
     * nell'array $datiEsame
     * 
     * @access public
     * @return Array I dati per memorizzare l'esame
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
