

<?php

/**
 * Description of VRegistrazione
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VRegistrazione extends View {

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
    public function getDatiValidi($dati)
    {
        return $this->_datiValidi;
    }

    /**
     * Metodo che consente di impostare la form della registrazione dell'utente.
     * Se è presente l'array $datiValidi alcuni campi della form vengo riempiti dai dati contenuti nell'array,
     * altrimenti la form presenterà tutti i campi vuoti
     * 
     * @access public
     * @param Array $datiValidi Dati validi di un precedente inserimento
     */
    public function restituisciFormUtente($datiValidi=NULL) 
    {
        if($datiValidi=== NULL)
        {
            $this->visualizzaTemplate('inserisciUtente');  
        }
        else
        {
            $this->assegnaVariabiliTemplate('datiValidi', $datiValidi);
            $this->visualizzaTemplate('inserisciUtente');
        }
      
    }

    /**
     * Metodo che consente di impostare la form della registrazione clinica.
     * Se è presente l'array $datiValidi alcuni campi della form vengo riempiti dai dati contenuti nell'array,
     * altrimenti la form presenterà tutti i campi vuoti
     * 
     * @access public
     * @param Array $datiValidi Dati validi di un precedente inserimento
     */
    public function restituisciFormClinica($datiValidi=NULL) 
    {
        // oss: questi dati validi non possiamo metterli come attributi di questa classe??? 
        
        if($datiValidi === NULL)
        {
            $this->visualizzaTemplate('inserisciClinica');  
        }
        else
        {
            $this->assegnaVariabiliTemplate('datiValidi', $datiValidi);
            $this->visualizzaTemplate('inserisciClinica', $datiValidi);
        }
    }
    
    /**
     * Metodo che consente di impostare la form della registrazione del medico.
     * Se è presente l'array $datiValidi alcuni campi della form vengo riempiti dai dati contenuti nell'array,
     * altrimenti la form presenterà tutti i campi vuoti
     * 
     * @access public
     * @param Array $datiValidi Dati validi di un precedente inserimento
     */
    public function restituisciFormMedico($datiValidi=NULL) 
    {
        if($datiValidi=== NULL)
        {
            $this->visualizzaTemplate('inserisciMedico');  
        }
        else
        {
            $this->assegnaVariabiliTemplate('datiValidi', $datiValidi);
            $this->visualizzaTemplate('inserisciMedico', $datiValidi);
        }
    }
    
    
    
    
    public function confermaInserimento()
    {
        //perchè devo inserire il return???
        
        $this->visualizzaTemplate('mailInviata');
    }
}
