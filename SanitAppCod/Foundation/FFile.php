<?php

/**
 * La classe FFile si occupa della gestione dei file.
 * 
 * @package Foundation
 * @author Claudia Di Marco & Riccardo Mantini
 */
class FFile {    
    
    /**
     * Costruttore della classe FFile
     */
    public function __construct() {
        
        $this->_path =  './uploadedFiles/';
        
    }
    
    /**
     * Controlla se il file esiste.
     * 
     * @access public
     * @param string $nomeFile Il nome del file da controllare
     * @return bool TRUE se il file esiste, FALSE altrimenti
     */
    public function checkFile($nomeFile) {
        
        return file_exists($this->_path . "/$nomeFile");
        
    }
    
    
    /**
     * Sposta il file dalla cartella temporanea nella cartella di destinazione.
     * 
     * @access public
     * @param string $tmpName il nome temporane del file
     * @param string $path Il percorso del file del tipo cartella/nomeFile
     * @return bool TRUE se lo spostamento ha avuto successo, FALSE altrimenti
     * 
     */
    public function spostaFile ($tmpName, $path) {
        
        return move_uploaded_file($tmpName, self::cartellaBase.$path);

    }
}
