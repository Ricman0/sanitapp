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

    
    /**
     * Metodo che permette di effettuare la ricerca di esami 
     * 
     * @param string $nomeEsame Il nome dell'esame di cui si vuole fare la ricerca
     * @param string $nomeClinica Il nome della clinica in cui si vuole fare ricerca
     * @param string $luogo Il luogo in cui si trova la clinica
     * @return array|boolean Se la query è stata eseguita con successo, ..., in caso contrario resituirà false.
     */
    public function cercaEsame($nomeEsame, $nomeClinica, $luogo)
    {
        $query="";
//        if($nomeEsame==="all")
//        {
//           $nomeEsame=""; 
//        }
//        if($nomeClinica==="all")
//        {
//           $nomeClinica=""; 
//        }
//        if($luogo==="all")
//        {
//           $luogo=""; 
//        }
//        if(!empty($nomeEsame))
//        {
//            echo "si nomeesame";
//            if (!empty($luogo)&& !empty($nomeClinica))
//            {
//                echo "si nomeesame, nomeclinica, luogo";
//                $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                        . "NumPrestazioniSimultanee, NomeCategoria, "
//                        . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                        . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                        . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                        . "OrarioChiusuraPM,OrarioContinuato "
//                        . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                        . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                        . " WHERE 'esame.Nome'='" . $nomeEsame . "' AND NomeClinica='"
//                        . $nomeClinica . "' AND ('clinica.Località'='" 
//                        . $luogo ."' OR 'clinica.Provincia'='" . $luogo . "' OR "
//                        . "'clinica.CAP'='" . $luogo . "')";
//            }
//            else
//            {
//                
//                if (!empty($nomeClinica))
//                {
//                    
//                    if (empty($luogo))
//                    {
//                        echo "si nomeesame, nomeclinica , no luogo";
//                        $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                            . "NumPrestazioniSimultanee, NomeCategoria, "
//                            . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                            . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                            . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                            . "OrarioChiusuraPM,OrarioContinuato "
//                            . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                            . "'esame.PartivaIVAClinica'='clinica.PartitaIVA "
//                            ." WHERE 'esame.Nome'='" . $nomeEsame . "' AND NomeClinica='"
//                            . $nomeClinica . "'";
//                    } 
//                }
//                else
//                {
//                    echo "si nomeesame, no nomeclinica, luogo";
//                    if (empty($luogo))
//                    {
//                        $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                            . "NumPrestazioniSimultanee, NomeCategoria, "
//                            . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                            . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                            . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                            . "OrarioChiusuraPM,OrarioContinuato "
//                            . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                            . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                            . " WHERE 'esame.Nome'='" . $nomeEsame . "'";
//                    }
//                    else
//                    {
//                        echo "si nomeesame,luogo,  no nomeclinica ";
//                        $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                        . "NumPrestazioniSimultanee, NomeCategoria, "
//                        . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                        . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                        . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                        . "OrarioChiusuraPM,OrarioContinuato "
//                        . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                        . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                        . " WHERE 'esame.Nome'='" . $nomeEsame . "' AND ('clinica.Località'='" 
//                        . $luogo ."' OR 'clinica.Provincia'='" . $luogo . "' OR 'clinica.CAP'='" . $luogo . "')";
//                    }
//                }
//            }
//        }
//        else
//        {
//             echo "no nomeesame ";
//            if (!empty($nomeClinica))
//            {
//                 echo "no nomeesame,  si nomeclinica ";
//                if (empty($luogo))
//                {
//                    echo "no nomeesame,luogo,  si nomeclinica ";
//                    $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                        . "NumPrestazioniSimultanee, NomeCategoria, "
//                        . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                        . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                        . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                        . "OrarioChiusuraPM,OrarioContinuato "
//                        . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                        . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                        . " WHERE NomeClinica='" . $nomeClinica . "'";
//                }
//                else
//                {
//                    echo "no nomeesame,  si nomeclinica, luogo ";
//                    $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                    . "NumPrestazioniSimultanee, NomeCategoria, "
//                    . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                    . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                    . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                    . "OrarioChiusuraPM,OrarioContinuato "
//                    . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                    . "'esame.PartivaIVAClinica'='clinica.PartitaIVA'"
//                    . " WHERE NomeClinica='" . $nomeClinica . "' AND ('clinica.Località'='" 
//                    . $luogo ."' OR 'clinica.Provincia'='" . $luogo . "' OR 'clinica.CAP'='" . $luogo . "')";
//                }
//            }
//            else
//            {
//                echo "no nomeesame,   nomeclinica ";
//                if (empty($luogo))
//                {
//                    echo "no nomeesame,   nomeclinica, luogo  ";
//                    $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                        . "NumPrestazioniSimultanee, NomeCategoria, "
//                        . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                        . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                        . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                        . "OrarioChiusuraPM,OrarioContinuato "
//                        . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                        . "'esame.PartivaIVAClinica'='clinica.PartitaIVA' ";
//                }
//                else
//                {
//                    echo "no nomeesame,   nomeclinica, si luogo ";
//                    $query = "SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                    . "NumPrestazioniSimultanee, NomeCategoria, "
//                    . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                    . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                    . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                    . "OrarioChiusuraPM,OrarioContinuato "
//                    . " FROM " . $this->_nomeTabella . " INNER JOIN clinica ON "
//                    . "'esame.PartivaIVAClinica'='clinica.PartitaIVA' "
//                    . " WHERE ('clinica.Località'='" . $luogo ."' OR 'clinica.Provincia'='" 
//                    . $luogo . "' OR 'clinica.CAP'='" . $luogo . "')";
//                }
//            }
//        }
//        
        
//        $risultato = $this->eseguiQuery("SELECT DISTINCT Nome, Descrizione, Prezzo, Durata, MedicoEsame, "
//                        . "NumPrestazioniSimultanee, NomeCategoria, "
//                        . "NomeClinica, clinica.Località, clinica.Provincia, clinica.CAP, "
//                        . "clinica.Via, clinica.NumCivico, clinica.Telefono, clinica.Email,"
//                        . "OrarioAperturaAM, OrarioChiusuraAM, OrarioAperturaPM, "
//                        . "OrarioChiusuraPM,OrarioContinuato "
//                        . " FROM esame INNER JOIN clinica;");
//        echo gettype($risultato);
//        $this->stampaRisultatoQuery($risultato);
        $risultato = $this->eseguiQuery("SELECT Nome, Prezzo FROM esame");
        return $risultato;
    }
}
