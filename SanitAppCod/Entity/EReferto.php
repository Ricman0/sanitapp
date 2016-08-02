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
     * Costruttore di EReferto
     * 
     * @param string $id
     * @param string $medico
     * @param blob $contenuto
     */
    public function __construct($id, $medico, $contenuto) 
    {
        $this->_IDReferto = $id;
        $this->_medicoReferto = $medico;
        $this->_contenuto = $contenuto;
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
    
    
}
