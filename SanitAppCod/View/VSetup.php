<?php

/**
 * La classe VSetup si occupa di recuperare i dati e visualizzare i template relativi al setup.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VSetup extends View{
    
    /**
     * @access private
     * @var array I dati validi inseriti precedentemente 
     */
    private $_datiValidi;
    
    /**
     * Metodo che consente di impostare i dati validi
     * 
     * @access public
     * @param array $dati I dati da impostare in $_datiValidi
     */
    public function setDatiValidi($dati)
    {
        $this->_datiValidi = $dati;
    }
    
    /**
     * Metodo che consente di ottenere sottoforma di Array i dati validi
     * 
     * @access public
     * @return array I dati contenuti in $_datiValidi
     */
    public function getDatiValidi()
    {
        return $this->_datiValidi;
    }

    /**
     * Metodo che restituisce la pagina di installazione dall'applicazione. 
     * 
     * @access public
     */
    public function restituisciPaginaInstallazione() {
        $formInstallazione = $this->prelevaTemplate('formInstallazione');
        $this->assegnaVariabiliTemplate('contenuto', $formInstallazione);
        $this->visualizzaTemplate('installazione');
        
    }
    
    /**
     * Metodo che consente di recuperare la form di istallazione.
     * 
     * @access public
     * @param array $dati Array contenente i dati validi
     * @param array $errore  Gli errori
     */
    public function restituisciFormInstallazione($dati = NULL, $errore= NULL) {
        if(isset($errore)){
            $this->assegnaVariabiliTemplate('errore', $errore);
           
        }
        if(isset($dati)){
            $this->assegnaVariabiliTemplate('datiInstallazione', $dati);
                    
        }
        $this->visualizzaTemplate('formInstallazione');
    }
    
     /**
     * Metodo che recupera i tutti i dati di installazione dalla form. I dati vengono memorizzati
     *  nell'array $datiInstallazione.
     * 
     * @access public
     * @return array I dati per installare l'applicazione
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
       $datiInstallazione['password'] = $this->recuperaValore('password');
       return $datiInstallazione;
    }
}
