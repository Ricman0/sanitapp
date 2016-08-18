<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FClinica
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FClinica extends FDatabase{
    
    /**
     * Costruttore della classe FClinica
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "clinica";
        $this->_attributiTabella = "partitaIVA, nomeClinica, titolareClinica, via, "+
                +"numeroCivico, CAP, email, PEC, username, password, telefono, "+
                +"capitaleSociale, orarioAperturaAM, orarioChiusuraAM, orarioAperturaPM"+
                +"orarioChiusuraPM, orarioContinuato"; 
    }
    
    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di una clinica nel database
     * 
     * @access private
     * @param EClinica $clinica la Clinica di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi separati da una virgola
     */
    private function getAttributi($clinica) 
    {
        $valoriAttributi = $clinica->getPartitaIVAClinica()+', ' +$clinica->getNomeClinica()+
                +', '+ $clinica->getTitolareClinica()+', '+
                + $clinica->getViaClinica()+', '+$clinica->getNumeroCivicoClinica()+', '+
                + $clinica->getCAPClinica() + ', '
                + $clinica->getEmailClinica() + ', ' + $clinica->getPECClinica()+
                +', ' + $clinica->getUsernameClinica()+ ', ' + $clinica->getPasswordClinica()+ ", "
                + $clinica->getTelefonoClinica()+', '+$clinica->getCapitaleSocialeClinica()+
                +', '+ $clinica->getOrarioAperturaAMClinica()+
                +', '+ $clinica->getOrarioChiusuraAMClinica()+', '+
                +$clinica->getOrarioAperturaPMClinica()+', '+
                $clinica->getOrarioChiusuraPMClinica()+', '+
                +$clinica->getOrarioContinuatoClinica();
        return $valoriAttributi;
    }
    
    /**
     * Metodo per inserire nella tabella Clinica una nuova riga ovvero
     * una nuova clinica
     * 
     * @param EClinica $clinica L'oggetto di tipo EClinica che si vuole salvare nella
     *                       tabella Clinica
     */
    public function inserisciClinica($clinica)
    {         
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($clinica);
        
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = 'INSERT INTO '+ $this->_nomeTabella +'('. $this->_attributiTabella .') VALUES('. $valoriAttributi.')';
        // eseguo la query
        $this->eseguiQuery($query);
    }
    
    
}
