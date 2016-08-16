<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FUtente
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FUtente extends FDatabase{
    
    /**
     * Costruttore della classe FUtente
     * 
     * @access public
     */
    public function __construct() 
    {
        //richiama il costruttore della classe FDatabase
        parent::__construct();
        // imposto il nome della tabella
        $this->_nomeTabella = "utente";
        $this->_attributiTabella = "Nome, Cognome, CodiceFiscale, Via, NumCivico, "
                . "CAP, Email, Username, Password";
    }
    
    
    /**
     * Metodo per inserire nella tabella Utente una nuova riga ovvero
     * un nuovo utente
     * 
     * @param EUtente $utente L'oggetto di tipo EUtente che si vuole salvare nella
     *                       tabella Utente
     */
    public function inserisciUtente($utente)
    {         
        //recupero i valori contenuti negli attributi
        $valoriAttributi = $this->getAttributi($utente);
        //la query da eseguire è la seguente:
        // INSERT INTO table_name (column1,column2,column3,...) VALUES (value1,value2,value3,...);
        $query = "INSERT INTO ". $this->_nomeTabella ."( ". $this->_attributiTabella .") VALUES( ". $valoriAttributi.")";
        // eseguo la query
        $this->eseguiQuery($query);
    }

    /**
     * Metodo che consente di ottenere in una stringa tutti gli attibuti necessari
     * per l'inserimento di un utente nel database
     * 
     * @access private
     * @param EUtente $utente L'utente di cui si vogliono ottenere i valori degli attributi 
     * @return string Stringa contenente i valori degli attributi (eccetto prenotazioni) separati da una virgola
     */
    private function getAttributi($utente) 
    {
        $valoriAttributi = $utente->getNomeUtente()+", " +$utente->getCognomeUtente()+
                +", " + $utente->getViaUtente()+", " +
                + $utente->getNumCivicoUtente()+", " +$utente->getCAPUtente()+", " +
                + $utente->getCodiceFiscaleUtente() + ", " 
                + $utente->getEmailUtente() + ", "  + $utente->getUsernameUtente() + 
                + ", " + $utente->getPasswordUtente() ;
        return $valoriAttributi;
    }
    
    
    /**
     * Metodo che consente di eliminare un utente dal database
     * 
     * @param string $cf Codice fiscale dell'utente da eliminare
     * @return boolean True se l'utente è stato eliminato, False altrimenti
     */
    public function eliminaUtente($cf)
    {
        $query = "DELETE FROM Utente WHERE CodFiscale = ".$cf;
        $eliminato = $this->_connessione->query($query);
        if($eliminato === TRUE)
        {
            echo "Utente eliminato correttamente dal database";
        }
        else 
        {
            echo "Si è verificato un errore durante l'eliminazione" .$this->_connessione->error;
        }
        return $eliminato;
    }
    
    /**
     * Metodo che permette di modificare un attributo di una tupla utente
     * 
     * @param string $attributo Il nome della colonna nella tabella utente 
     *               di cui si vuole modificare il valore del contenuto
     * @param string $valore Il valore con il quale modificare il vecchio valore
     */
    
    
    /**
     * 
     */
}
