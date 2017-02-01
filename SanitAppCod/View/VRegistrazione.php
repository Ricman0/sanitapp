

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
    public function getDatiValidi()
    {
        return $this->_datiValidi;
    }

    /**
     * Metodo che consente di impostare la form della registrazione dell'utente.
     * Se è presente l'array $datiValidi alcuni campi della form vengo riempiti dai dati contenuti nell'array,
     * altrimenti la form presenterà tutti i campi vuoti.
     * 
     * @access public
     * @param array $datiValidi Dati validi di un precedente inserimento        //controllato
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
     * @param array $datiValidi Dati validi di un precedente inserimento
     */
    public function restituisciFormClinica($datiValidi=NULL)                    //controllato
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
     * @param array $datiValidi Dati validi di un precedente inserimento        //controllato
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
    
    /**
     * Metodo che recupera i tutti i dati della clinica dalla form 
     * per poter inserire una nuova clinica. I dati vengono memorizzati
     * nell'array $datiClinica
     * 
     * @access public
     * @return Array I dati per memorizzare la clinica
     */
    public function recuperaDatiClinica()
    {
        $datiClinica = Array();
        $datiClinica['nomeClinica'] = $this->recuperaValore('nomeClinica');
        $datiClinica['titolare'] = $this->recuperaValore('titolare'); 
        $datiClinica['partitaIVA'] = $this->recuperaValore('partitaIVA');
        $datiClinica['via'] = $this->recuperaValore('indirizzoClinica');
        $datiClinica['numeroCivico'] = $this->recuperaValore('numeroCivicoClinica');
        $datiClinica['cap'] = $this->recuperaValore('CAPClinica');
        $datiClinica['localitàClinica'] = $this->recuperaValore('localitàClinica');
        $datiClinica['provinciaClinica'] = $this->recuperaValore('provinciaClinica');
        $datiClinica['email'] = $this->recuperaValore('email');
        $datiClinica['username'] = $this->recuperaValore('username');
        $datiClinica['password'] = $this->recuperaValore('passwordClinica');
        $datiClinica['PEC'] = $this->recuperaValore('PEC');
        $datiClinica['telefono'] = $this->recuperaValore('telefonoClinica');
        $datiClinica['capitaleSociale'] = $this->recuperaValore('capitaleSociale');        
        return $datiClinica;
    }
    
    /**
     * Metodo che recupera i tutti i dati del medico dalla form 
     * per poter inserire un nuovo medico. I dati vengono memorizzati
     *  nell'array $datiMedico
     * 
     * @access public
     * @return Array I dati per memorizzare il medico
     */
    public function recuperaDatiMedico()
    {
        $datiMedico = Array();
        $datiMedico['nome'] = $this->recuperaValore('nomeMedico');
        $datiMedico['cognome'] = $this->recuperaValore('cognomeMedico'); 
        $datiMedico['codiceFiscale'] = $this->recuperaValore('codiceFiscale');
        $datiMedico['via'] = $this->recuperaValore('indirizzoMedico');
        $datiMedico['numeroCivico'] = $this->recuperaValore('numeroCivicoMedico');  
        $datiMedico['CAP'] = $this->recuperaValore('CAPMedico');
        $datiMedico['email'] = $this->recuperaValore('email');
        $datiMedico['username'] = $this->recuperaValore('username');
        $datiMedico['password'] = $this->recuperaValore('passwordMedico');
        $datiMedico['PEC'] = $this->recuperaValore('PEC');
        $datiMedico['provinciaAlbo'] = $this->recuperaValore('provinciaAlbo');
        $datiMedico['numeroIscrizione'] = $this->recuperaValore('numeroIscrizione'); 
        return $datiMedico;
    }
    
    /**
     * Metodo che recupera i tutti i dati di un utente dalla form 
     * per poter inserire un nuovo utente. I dati vengono memorizzati
     *  nell'array $datiUtente
     * 
     * @access public
     * @return Array I dati per memorizzare l'utente
     */
    public function recuperaDatiUtente()
    {
        //creo un array in cui inserirsco i valori recuperati
        //pb: secondo te è una stupidaggine fare così e poi aggiungo del tempo  inutile
       $datiUtente = Array();
//       $nome = $this->recuperaValore('nome');    
       $datiUtente['nome'] = $this->recuperaValore('nome');
       $datiUtente['cognome'] = $this->recuperaValore('cognome'); 
       $datiUtente['codiceFiscale'] = $this->recuperaValore('codiceFiscale');
       $datiUtente['indirizzo'] =$this->recuperaValore('indirizzo');
       $datiUtente['numeroCivico'] = $this->recuperaValore('numeroCivico');  
       
       $datiUtente['CAP'] = $this->recuperaValore('CAP');
       $datiUtente['email'] = $this->recuperaValore('email');
       $datiUtente['username'] =$this->recuperaValore('username');
       $datiUtente['password'] = $this->recuperaValore('passwordUtente');
       return $datiUtente;
    }
    
//    public function confermaMailInviata($inviata)
//    {        
//        $this->assegnaVariabiliTemplate("inviata", $inviata);
//        $this->visualizzaTemplate('mailInviata');
//    }
}
