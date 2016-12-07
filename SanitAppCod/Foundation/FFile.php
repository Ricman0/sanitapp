<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FFile
 *
 * @author Riccardo
 */
class FFile {    
    
    public function __construct() {
        
        $this->_path =  './uploadedFiles/';
        
    }
    
    /**
     * Controlla se il file esiste
     * @param string $nomeFile Il nome del file da controllare
     * @return bool TRUE se il file esiste, FALSE altrimenti
     */
    public function checkFile($nomeFile) {
        
        return file_exists($this->_path . "/$nomeFile");
        
    }
    
    
    /**
     * Sposta il file dalla cartella temporanea nella cartella di destinazione
     * @param string $tmpName il nome temporane del file
     * @param string $path Il percorso del file del tipo cartella/nomeFile
     * @return bool TRUE se lo spostamento ha avuto successo, FALSE altrimenti
     * 
     */
    public function spostaFile ($tmpName, $path) {
        
        return move_uploaded_file($tmpName, self::cartellaBase.$path);

    }
}
