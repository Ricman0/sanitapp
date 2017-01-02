<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VSetup
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VSetup extends View{
    
    /**
     * @access private
     * @var Array I dati validi inseriti precedentemente 
     */
    private $_datiValidi;
    
    /**
     * Metodo che consente di impostare i dati validi
     * 
     * @access public
     * @param Array $dati I dati da impostare in $_datiValidi
     */
    public function setDatiValidi($dati)
    {
        $this->_datiValidi = $dati;
    }
    
    /**
     * Metodo che consente di ottenere sottoforma di Array i dati validi
     * 
     * @access public
     * @return Array I dati contenuti in $_datiValidi
     */
    public function getDatiValidi()
    {
        return $this->_datiValidi;
    }

    /**
     * Metodo che  restituisce la form di installazione dalla form. 
     * 
     * @access public
     */
    public function restituisciPaginaInstallazione($dati = NULL) {
        if(isset($dati)){
            $this->assegnaVariabiliTemplate('datiInstallazione', $dati);
                    
        }
        $this->visualizzaTemplate('installazione');
        
    }
    
     /**
     * Metodo che recupera i tutti i dati di installazione dalla form. I dati vengono memorizzati
     *  nell'array $datiInstallazione
     * 
     * @access public
     * @return Array I dati per installare l'applicazione
     */
    public function recuperaDatiInstallazione()
    {
       $datiInstallazione = Array();
       $datiInstallazione['host'] = $this->recuperaValore('host');
       $datiInstallazione['userDb'] = $this->recuperaValore('userDb');
       $datiInstallazione['passwordDb'] = $this->recuperaValore('passwordDb');
       $datiInstallazione['smtp'] = $this->recuperaValore('smtp');
       $datiInstallazione['email'] = $this->recuperaValore('emailSmtp'); 
       $datiInstallazione['passwordEmail'] = $this->recuperaValore('passwordEmail');
       $datiInstallazione['nome'] = $this->recuperaValore('nome');
       $datiInstallazione['cognome'] = $this->recuperaValore('cognome'); 
       $datiInstallazione['emailAdmin'] = $this->recuperaValore('emailAdmin');
       $datiInstallazione['PEC'] = $this->recuperaValore('pecAdmin');
       $datiInstallazione['telefono'] = $this->recuperaValore('telefono');
       $datiInstallazione['username'] =$this->recuperaValore('username');
       $datiInstallazione['password'] = $this->recuperaValore('passwordUtente');
       return $datiInstallazione;
    }
}
