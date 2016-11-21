<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EReferto
 * 
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EReferto {
    
    /*
     * Attributi della classe EReferto
     */
    
    /**
     * @var string $_IDReferto Identificativo del referto 
     * Suppongo di mettere "R+IDPrenotazione"
     */
    private $_IDReferto;
    
    /**
     *
     * @var string id della prenotazione realtiva all referto
     */
    private $_idPrenotazione;
    
    /**
     *
     * @var string $_idEsame identificativo dell'esame relativo al referto
     */
    private $_idEsame;


    /**
     * @var string $_medicoReferto Cognome e nome del medico che scrive il referto 
     */
    private $_medicoReferto;
    
    /**
     * @var string $_contenuto Il nome del file referto
     */
    private $_contenuto;
    
    /**
     * @var date $_dataReferto la data di inserimento del referto
     */
    private $_dataReferto;
   
    /**
     *
     * @var string $_partitaIVAClinica partita iva della clinica che emette il referto
     */
    private $_partitaIVAClinica;
    
    
    const cartellaReferti = './uploadedFiles/referti/';


    /**
     * Costruttore di EReferto
     * 
     * @param string $medico
     * @param blob $contenuto
     */    
    public function __construct($idPrenotazione, $partitaIvaClinica=NULL, $idEsame=NULL, $medico=NULL,  $contenuto=NULL) 
    {
        if($medico!==NULL)
        {
            $this->_IDReferto = uniqid();
            $this->_idPrenotazione = $idPrenotazione;
            $this->_idEsame = $idEsame;
            $this->_partitaIVAClinica = $partitaIvaClinica;
            $this->_medicoReferto = $medico;
            $this->_contenuto = $contenuto;
            $this->_dataReferto = date('Y-m-d', time());
        }
        else
        {
            $fReferto = USingleton::getInstance('FReferto');
            $risultato = $fReferto->cercaReferto($idPrenotazione);
            print_r($risultato);
            if(is_array($risultato) && count($risultato)===1)
            {
                $this->_IDReferto = $risultato[0]['IDReferto'];
                $this->_idPrenotazione = $risultato[0]['IDPrenotazione'];
                $this->_idEsame = $risultato[0]['IDEsame'];
                $this->_partitaIVAClinica = $risultato[0]['PartitaIVAClinica'];
                $this->_medicoReferto = $risultato[0]['MedicoReferto'];
                $this->_contenuto = $risultato[0]['Contenuto'];
                $this->_dataReferto = $risultato[0]['DataReferto'];
            }
            else 
            {
                $this->_IDReferto = NULL;
            }
        }
    }
    
    //metodi get
    /**
     * Metodo che restituisce l'identificativo del referto
     * 
     * @return string L'id del referto
     */
    public function getIDReferto()
    {
        return $this->_IDReferto;
    }
    
    /**
     * Metodo che restituisce l'identificativo della prenotazione
     * 
     * @return string L'id della prenotazione
     */
    public function getIDPrenotazione()
    {
        return $this->_idPrenotazione;
    }
    
    /**
     * Metodo che restituisce l'identificativo dell'esame
     * 
     * @return string L'id dell'esame
     */
    public function getIDEsame()
    {
        return $this->_idEsame;
    }
    
    /**
     * Metodo che restituisce la partita iva della clinica
     * 
     * @return string la partita iva della clinica
     */
    public function getPartitaIvaClinica()
    {
        return $this->_partitaIVAClinica;
    }
    
    /**
     * Metodo che restituisce il nome del medico che ha scritto il referto
     * 
     * @return string Il medico che ha scritto il referto
     */
    public function getMedicoReferto()
    {
        return $this->_medicoReferto;
    }
    
    /**
     * Metodo che restituisce il contenuto del referto
     * 
     * @return blob Il contenuto del referto
     */
    public function getContenutoReferto()
    {
        return $this->_contenuto;
        
    }
    
    /**
     * Metodo che restituisce la data del referto
     * 
     * @return date la data del referto
     */
    public function getDataReferto()
    {
        return $this->_dataReferto;
    }
    
    /**
     * 
     * @return bool
     */
    public function inserisciReferto() {
        
        $fReferto = USingleton::getInstance('FReferto');
        return $fReferto->inserisciReferto($this);
        
    }
    
    /**
     * Sposta il file del referto dalla cartella temporanea nella cartella dei referti
     * @param string $tmpName il nome temporane del file
     */
    public function spostaReferto($tmpName) {
        
        return move_uploaded_file($tmpName, self::cartellaReferti.$this->_contenuto);

    }
    
}
