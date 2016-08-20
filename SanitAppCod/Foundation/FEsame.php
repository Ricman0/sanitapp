<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FEsame
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FEsame extends FDatabase{
    
    /**
     * Costruttore della classe FEsame
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "esame";
        $this->_attributiTabella = "IDEsame, Nome, Descrizione, Prezzo, "+
                +"Durata, MedicoEsame, NumPrestazioniSimultanee,"
                . " NomeCategoria, PartitaIVAClinica"; 
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di una esame nel database
     * 
     * @access private
     * @param EEsame $esame l'esame di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    private function getAttributi($esame) 
    {
        $valoriAttributi = $esame->getNomeEsame()+
                +', '+ $esame->getDescrizioneEsame()+', '+
                + $esame->getPrezzoEsame()+', '+$esame->getDurataEsame()+', '+
                + $esame->getMedicoEsame() + ', '
                + $esame->getNumeroPrestazioniSimultaneeEsame() + ', ' + $esame->getNomeCategoriaEsame();
        return $valoriAttributi;
    }
    
    /**
     * Metodo per inserire nella tabella Esame una nuova riga ovvero
     * una nuovo esame
     * 
     * @param EEsame $esame L'oggetto di tipo EEsame che si vuole salvare nella
     *                       tabella Esame
     */
    public function inserisciEsame($esame)
    {         
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($esame);
        
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = 'INSERT INTO '+ $this->_nomeTabella +'('. $this->_attributiTabella .') VALUES('. $valoriAttributi.')';
        // eseguo la query
        $this->eseguiQuery($query);
    }
    
    /*
     * 
     */
    public function recuperaEsami($nome, $clinica, $luogo){
        
        $query = 'SELECT * FROM esame WHERE nome = ' + "'" + $nome + "'";
        return $this->eseguiQuery($query);
        
    }
    
    
}
