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
     * @var blob $_contenuto Il contenuto del referto può essere un testo, 
     * un'immagine, un video, un mix di tutti. per questo in mysql abbiamo 
     * scelto il tipo longblob ma in php cosa devo mettere??
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


    /**
     * Costruttore di EReferto
     * 
     * @param string $medico
     * @param blob $contenuto
     */    
    public function __construct($idPrenotazione, $partitaIvaClinica, $idEsame, $medico=NULL,  $contenuto=NULL) 
    {
        $this->_IDReferto = uniqid();
        $this->_idPrenotazione = $idPrenotazione;
        $this->_idEsame = $idEsame;
        $this->_partitaIVAClinica = $partitaIvaClinica;
        $this->_medicoReferto = $medico;
        $this->_contenuto = $contenuto;
        $this->_dataReferto = date('Y-m-d', time());
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
    
    
}
