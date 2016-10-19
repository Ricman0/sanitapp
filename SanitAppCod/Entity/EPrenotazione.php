<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EPrenotazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EPrenotazione {
    
    /*
     * Attributi della classe EPrenotazione
     */
    
    /**
     * @var string $_idPrenotazione Identificativo della prenotazione
     */
    private $_idPrenotazione;
    
    /**
     * @var string $_idEsame Identificativo dell'esame di cui si vuole effettuare la prenotazione
     */
    private $_idEsame;
    
    /**
     * @var string $_partitaIVA Partita IVA della clinica in cui si vuole effettuare la prenotazione
     */
    private $_partitaIVA;
    
    /**
     * @var string $_tipo Il tipo di utente che effettua la prenotazione (M medico, U utente) 
     */
    private $_tipo;
    
    /**
     * @var boolean $_confermata La conferma della prenotazione 
     */
    private $_confermata;
    
    /**
     * @var boolean $_eseguita La prenotazione è stata eseguita
     */
    private $_eseguita;
    
    /**
     * @var string $_codFisUtenteEffettuaEsame Il codice fiscale dell'utente che effettua l'esame
     */
    private $_codFisUtenteEffettuaEsame;
    
    /**
     * @var string $_codFisUtentePrenotaEsame Il codice fiscale dell'utente che prenota l'esame
     */
    private $_codFisUtentePrenotaEsame;
    
    /**
     * @var string $_codFisMedicoPrenotaEsame Il codice fiscale del medico che prenota l'esame
     */
    private $_codFisMedicoPrenotaEsame;
    
    /**
     * @var DateTime $_dataEOra La data e l'ora della prenotazione
     */
    private $_dataEOra;
    
    /*
     * Costruttore della classe EPrenotazione
     */
    public function __construct($id=NULL,$idEsame="",$partitaIVAClinica="", $tipo="", $codFiscaleUtenteEffettuaEsame=NULL,$codFiscalePrenotaEsame=NULL, $dataEOra="" ) 
    {
        if(isset($id))
        {
            $fPrenotazione = USingleton::getInstance('FPrenotazione');
            $attributiPrenotazione = $fPrenotazione->cercaPrenotazioneById($id);
            if(is_array($attributiPrenotazione) && count($attributiPrenotazione)==1)
            {
                
                $this->_idPrenotazione = $id;
                $this->_idEsame = $attributiPrenotazione[0]["IDEsame"];
                $this->_partitaIVA = $attributiPrenotazione[0]["PartitaIVAClinica"];
                $this->_tipo = $attributiPrenotazione[0]["Tipo"];  
                $this->_confermata = $attributiPrenotazione[0]["Confermata"];
                $this->_eseguita = $attributiPrenotazione[0]["Eseguita"];
                $this->_codFisUtenteEffettuaEsame = $attributiPrenotazione[0]["CodFiscaleUtenteEffettuaEsame"];
                $this->_codFisUtentePrenotaEsame = $attributiPrenotazione[0]["CodFiscaleEffettuaPrenotaEsame"];
                $this->_codFisMedicoPrenotaEsame= $attributiPrenotazione[0]["CodFiscaleMedicoPrenotaEsame"];
                $this->_dataEOra =  new DateTime($attributiPrenotazione[0]["DataEOra"]);
                
            }
        }
        else
        {
            $this->_idPrenotazione = uniqid();
            $this->_idEsame = $idEsame;
            $this->_partitaIVA = $partitaIVAClinica;
            $this->_tipo = $tipo; 
            if($tipo = "M")
            {
                $this->_codFisUtentePrenotaEsame = NULL;
                $this->_codFisMedicoPrenotaEsame = $codFiscalePrenotaEsame;
                $this->_confermata = "FALSE";
            }
            else
            {
                $this->_codFisUtentePrenotaEsame = $codFiscalePrenotaEsame;
                $this->_codFisMedicoPrenotaEsame = NULL;
                $this->_confermata = "TRUE";
            }
            
            $this->_eseguita = "FALSE";
            $this->_codFisUtenteEffettuaEsame = $codFiscaleUtenteEffettuaEsame;
            $this->_dataEOra = $this->setDataEOra($dataEOra);
        }
    }
    
    /*
     * Metodi get
     */
    
    /**
     * Metodo che permette di conoscere l'identificativo della prenotazione
     * 
     * @access public
     * @return string L'id della prenotazione
     */
    public function getIdPrenotazione() 
    {
        return $this->_idPrenotazione;
    }
    
    /**
     * Metodo che permette di conoscere l'identificativo dell'esame della prenotazione
     * 
     * @access public
     * @return string L'id dell'esame della prenotazione
     */
    public function getIdEsamePrenotazione() 
    {
        return $this->_idEsame;
    }
    
    /**
     * Metodo che permette di conoscere la partita IVA della clinica in cui si effettua la prenotazione
     * 
     * @access public
     * @return string La partita IVA della clinica in cui si effettua la prenotazione
     */
    public function getPartitaIVAPrenotazione() 
    {
        return $this->_partitaIVA;
    }
    
    /**
     * Metodo che permette di conoscere il tipo di utente che effettua la prenotazione
     * 
     * @access public
     * @return string Il tipo di utente che effettua la prenotazione
     */
    public function getTipoPrenotazione() 
    {
        return $this->_tipo;
    }
    
    /**
     * Metodo che permette di conoscere se la prenotazione è stata confermata
     * 
     * @access public
     * @return boolean TRUE è stata confermata, FALSE altrimenti
     */
    public function getConfermataPrenotazione() 
    {
        return $this->_confermata;
    }
    
    /**
     * Metodo che permette di conoscere se la prenotazione è stata eseguita
     * 
     * @access public
     * @return boolean $eseguita TRUE se è stata eseguita, FALSE altrimenti
     */
    public function getEseguitaPrenotazione() 
    {
        return $this->_eseguita;
    }
    
    /**
     * Metodo che permette di conoscere il codice fiscale dell'utente che effettua l'esame
     * 
     * @access public
     * @return string $_codFisUtenteEffettuaEsame Il codice fiscale dell'utente che effettua l'esame
     */
    public function getUtenteEffettuaEsamePrenotazione() 
    {
        return $this->_codFisUtenteEffettuaEsame;
    }
    
    /**
     * Metodo che permette di conoscere il codice fiscale dell'utente che prenota l'esame
     * 
     * @access public
     * @return string $_codFisUtentePrenotaEsame Il codice fiscale dell'utente che prenota l'esame
     */
    public function getUtentePrenotaEsamePrenotazione() 
    {
        return $this->_codFisUtentePrenotaEsame;
    }
    
    /**
     * Metodo che permette di conoscere il codice fiscale del medico che prenota l'esame
     * 
     * @access public
     * @return string $_codFisMedicoPrenotaEsame Il codice fiscale del medico che prenota l'esame
     */
    public function getMedicoPrenotaEsamePrenotazione() 
    {
        return $this->_codFisMedicoPrenotaEsame;
    }
    
    /**
     * Metodo che permette di conoscere la data e l'ora della prenotazione nel formato dd-mm-yyyy hh:mm
     * 
     * @access public
     * @return string La data e l'orario della prenotazione 
     */
    public function getDataEOra() 
    {
        
        return $this->_dataEOra->format('d-m-Y H:i');
               
    }
    
    /**
     * Metodo che permette di conoscere la data della prenotazione nel formato dd-mm-yyyy hh:mm
     * 
     * @access public
     * @return string La data e l'orario della prenotazione 
     */
    public function getData() 
    { 
        return $this->_dataEOra->format('d-m-Y');
    }
    
    /**
     * Metodo che permette di conoscere l'ora della prenotazione nel formato dd-mm-yyyy hh:mm
     * 
     * @access public
     * @return string La data e l'orario della prenotazione 
     */
    public function getOra() 
    {
        
        return $this->_dataEOra->format('H:i');
    }
    
    /**
     * Metodo che consente di ottenere in forma di stringa tutti i valori degli attributi
     * 
     * @access public
     * @return string $valoriAttributi Una stringa contennete tutti i valori degli attributi
     */
    public function getValoriAttributi()
    {
        ;
        $valoriAttributi = "'" . $this->getIdPrenotazione() . "', '" .  $this->getIdEsamePrenotazione() . "', '"
                . $this->getPartitaIVAPrenotazione() . "', '" . $this->getTipoPrenotazione() . "', '"
                . $this->getConfermataPrenotazione() . "', '" . $this->getEseguitaPrenotazione() . "', '"
                . $this->getUtenteEffettuaEsamePrenotazione()  . "', ";
        if ($this->getUtentePrenotaEsamePrenotazione()=== NULL)
        {
            $valoriAttributi =$valoriAttributi .  " NULL , '" . $this->getMedicoPrenotaEsamePrenotazione() . "', '";
        }
        else 
        {
            $valoriAttributi = $valoriAttributi . "'". $this->getUtentePrenotaEsamePrenotazione() . "', NULL ,'";
        }
                
                
                $valoriAttributi =$valoriAttributi . $this->getDataEOra() . "'";
        return $valoriAttributi;
    }
    /*
     * Metodi set
     */
    
    /**
     * Metodo che consente di impostare l'identificativo della prenotazione
     * 
     * @access public
     * @param string $idPrenotazione L'id da impostare
     */
    public function setIdPrenotazione($idPrenotazione) 
    {
        $this->_idPrenotazione = $idPrenotazione;
    }
   
    /**
     * Metodo che consente di impostare l'identificativo dell'esame della prenotazione
     * 
     * @access public
     * @param string $id L'id dell'esame da impostare
     */
    public function setIdEsamePrenotazione($id) 
    {
        $this->_idEsame = $id;
    }
    
    /**
     * Metodo che consente di impostare la partita IVA della clinica in cui si effettua la prenotazione
     * 
     * @access public
     * @param string $partitaIVA La partita IVA della clinica in cui si effettua la prenotazione
     */
    public function setPartitaIVAPrenotazione($partitaIVA) 
    {
        $this->_partitaIVA = $partitaIVA;
    }
    
    /**
     * Metodo che permette di impostare il tipo di utente che effettua la prenotazione
     * 
     * @access public
     * @param string $tipo Il tipo di utente che effettua la prenotazione
     */
    public function setTipoPrenotazione($tipo) 
    {
        $this->_tipo = $tipo;
    }
    
    /**
     * Metodo che permette di impostare la conferma della prenotazione
     * 
     * @access public
     * @param boolean $confermata TRUE se è stata confermata, FALSE altrimenti
     */
    public function setConfermataPrenotazione($confermata) 
    {
        $this->_confermata = $confermata;
    }
    
    /**
     * Metodo che permette di impostare ad eseguita la prenotazione
     * 
     * @access public
     * @param boolean $eseguita TRUE se è stata eseguita, FALSE altrimenti
     */
    public function setEseguitaPrenotazione($eseguita) 
    {
        $this->_eseguita = $eseguita;
    }
    
    /**
     * Metodo che permette di impostare il codice fiscale dell'utente che effettua l'esame
     * 
     * @access public
     * @param string $codFis Il codice fiscale dell'utente che effettua l'esameboolean $eseguita TRUE se è stata eseguita, FALSE altrimenti
     */
    public function setUtenteEffettuaEsamePrenotazione($codFis) 
    {
        $this->_codFisUtenteEffettuaEsame = $codFis;
    }
    
    /**
     * Metodo che permette di impostare il codice fiscale dell'utente che prenota l'esame
     * 
     * @access public
     * @param string $codFis Il codice fiscale dell'utente che prenota l'esame
     */
    public function setUtentePrenotaEsamePrenotazione($codFis) 
    {
        $this->_codFisUtentePrenotaEsame = $codFis;
    }
    
    /**
     * Metodo che permette di impostare il codice fiscale del medico che prenota l'esame
     * 
     * @access public
     * @param string $codFis Il codice fiscale del medico che prenota l'esame
     */
    public function setMedicoPrenotaEsamePrenotazione($codFis ) 
    {
        $this->_codFisMedicoPrenotaEsame = $codFis ;
    }
    
    /**
     * Metodo che permette di impostare la data e l'ora della prenotazione
     * 
     * @access public
     * @parame string La data e l'orario della prenotazione in formato dd-mm-yyyy hh:ii
     */
    public function setDataEOra($dataEOra) 
    {
        $this->setData($dataEOra);
        $this->setOra($dataEOra);
        
    }
    
    /**
     * Metodo che permette di impostare la data  della prenotazione
     * 
     * @access public
     * @param string La data e l'ora della prenotazione in formato dd-mm-yyyy hh:ii
     */
    public function setData($dataEOra) 
    {
        $data = new DateTime();
        $anno = substr($dataEOra, 6, 4);
        $mese = substr($dataEOra, 3, 2);
        $giorno = substr($dataEOra, 0, 2);
        $this->_dataEOra = $data->setDate( $anno , $mese, $giorno );
    }
    
    /**
     * Metodo che permette di impostare l'ora della prenotazione
     * 
     * @access public
     * @param string La data e l'ora della prenotazione in formato dd-mm-yyyy hh:ii
     */
    public function setOra($dataEOra) 
    {
        $data = new DateTime();
        $ora = substr($dataEOra, 14, 2);
        $minuto = substr($dataEOra, 11, 2);
        $this->_dataEOra = $data->setTime($ora , $minuto);
    }
    
    /*
     * Altri metodi
     */
    public function aggiungiPrenotazioneDB($ePrenotazione) 
    {
        $fPrenotazione = USingleton::getInstance('FPrenotazione');
        echo " ancora oK";
        return $fPrenotazione->aggiungiPrenotazione($ePrenotazione);
    }
    
}
