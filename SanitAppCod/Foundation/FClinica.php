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
    
    /**
     * Metodo che permette di effettuare la ricerca di cliniche 
     * 
     * @param string $luogo Il luogo in cui si trova la clinica
     * @param string $nome Il nome della clinica che si vuole cercare
     * @return array|boolean Se la query è stata eseguita con successo, ..., in caso contrario resituirà false.
     */
    public function cercaClinica($nome, $luogo)
    {
        if($nome == "all")
        {
            $nome = "";
        }
        else
        {
            $nome = str_replace("_", " ", $nome);
        }
        if($luogo == "all")
        {
            $luogo = "";
        }
        else
        {
            $luogo = str_replace("_", " ", $luogo);
        }
        
        if(!empty($nome))
        {
            echo "si nomeClinica";
            if(!empty($luogo))
            {
                echo " si nomeClinica, luogo";
                $query =  "SELECT NomeClinica, Località, Provincia, "
                        . "MATCH (NomeClinica) AGAINST ('$nome' IN BOOLEAN MODE), "
                        . "MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "FROM clinica "
                        . "WHERE (MATCH (NomeClinica) AGAINST('$nome' IN BOOLEAN MODE) "
                        . "AND (MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (CAP) AGAINST ('$luogo' IN BOOLEAN MODE)))";
            }
            else
            {  
                echo " si nomeClinica, no luogo";
                $query =  "SELECT NomeClinica, Località, Provincia, "
                        . "MATCH (NomeClinica) AGAINST ('$nome' IN BOOLEAN MODE) "
                        . "FROM clinica "
                        . "WHERE MATCH (NomeClinica) AGAINST('$nome' IN BOOLEAN MODE)";
            }
        }
        else
        {
            echo "no nomeClinica";
            if(!empty($luogo))
            {
                echo "no nomeClinica, si luogo";
                $query =  "SELECT NomeClinica, Località, Provincia, "
                        . "MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE), "
                        . "MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "FROM clinica "
                        . "WHERE (MATCH (Località) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (Provincia) AGAINST ('$luogo' IN BOOLEAN MODE) "
                        . "OR MATCH (CAP) AGAINST ('$luogo' IN BOOLEAN MODE))";
            }
            else
            {
                echo "no nomeClinica, no luogo";
                $query = "SELECT NomeClinica, Località, Provincia FROM clinica";
            }
        }
        
        
        /* vecchia versione
        if (!empty($luogo)&& !empty($nome))
        {
            $query = "SELECT * FROM ".$this->_nomeTabella." WHERE NomeClinica = '"
                    . $nome . "' AND (Località =  '" . $luogo ."' OR Provincia='" . $luogo . "' OR CAP='" . $luogo . "')";
        }
        elseif(!empty ($luogo))
        {
            $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE (Località =  '" 
                    . $luogo . "' OR Provincia='" . $luogo . "' OR CAP='" . $luogo . "')";
            
        }
        elseif (!empty($nome)) 
        {
            $query = "SELECT * FROM " . $this->_nomeTabella . " WHERE NomeClinica = '"
                    . $nome . "'";
        }
        else
        {
            $query = "SELECT * FROM " . $this->_nomeTabella;
        }
        fine vecchia versione*/
        
        $risultato = $this->eseguiQuery($query);
        return $risultato;
    }
}
