<?php

/**
 * Description of UValidazione 
 * La classe UValidazione consente di effettuare la validazione lato server 
 * dei dati immessi nella form
 * 
 * @package Utility
 * @author Claudia Di Marco & Riccardo Mantini
 */

class UValidazione {
    
    /**
     * Array contenente tutti gli input giusti/validati 
     * 
     * @access private
     * @var Array Array contenente tutti gli input validati
     */
    private $_datiValidi;
    
    /**
     * Array contenente tutti gli input sbagliati 
     * 
     * @access private
     * @var Array Array contenente tutti gli input sbagliati 
     */
    private $_datiErrati;
    
    /**
     * Variabile booleana che permette di capire se i dati sonno sono validi 
     * 
     * @access private
     * @var boolean TRUE i dati sono stati validati, FALSE altrimenti
     */
    private $_validati;
    
    /**
     * Costruttore della classe UValidazione
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_datiValidi = Array();
        $this->_datiErrati = Array();
        $this->_validati = TRUE;
    }
    
    /**
     * Metodo che consente di conoscere i dati  validati
     * 
     * @access public
     * @return Array I dati validi
     */
    public function getDatiValidi() 
    {
        return $this->_datiValidi;
    }
    
    /**
     * Metodo che consente di conoscere se i dati sono validati
     * 
     * @access public
     * @return boolean TRUE dati validi, FALSE almeno un dato non era valido
     */
    public function getValidati() 
    {
        return $this->_validati;
    }
    
    /**
     * Metodo che consente di conoscere gli errori che si sono verificati 
     * durante la validazione dei dati
     * 
     * @access public
     * @return Array I dati sbagliati
     */
    public function getDatiErrati() 
    {
        return $this->_datiErrati;
    }
   
    /**
     * Metodo che consente di impostare  validati a true
     * 
     * @access private
     * @param boolean TRUE dati validi, FALSE almeno un dato non era valido
     */
    private function setValidati($validati) 
    {
        $this->_validati = $validati;
    }
    
    /**
     * Metodo che permette la validazione del codice fiscale
     * 
     * @access public
     * @param string $codiceFiscale Il codice fiscale da validare
     * @return boolean TRUE codice fiscale valido, False altrimenti
     */
    public function validaCodiceFiscale($codiceFiscale) 
    {
        $this->setValidati(TRUE);
        $pattern = '/^[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}$/' ;
        $stringaErrore = "Il codice fiscale è una sequenza di alfanumerica del tipo DMRCLD89S42G438S ";
        if (preg_match($pattern, $codiceFiscale)) 
        {
//            echo $codiceFiscale;
            $this->_datiErrati['codiceFiscale'] = FALSE;
            $this->_datiValidi['codiceFiscale'] = $codiceFiscale;
//            echo "OK";
//            echo ($this->getValidati());
        } 
        else
        {
            
            $this->_datiErrati['codiceFiscale'] = $stringaErrore;
//            echo ($this->_datiErrati['codiceFiscale']);
//            echo "NO";
            $this->_validati = FALSE;
//            echo ($this->getValidati());
        }
        return $this->_validati;
        
    }
    
    /**
     * Metodo che permette la validazione di tutti i dati dell'utente
     * 
     * @access public
     * @param Array $datiUtente Dati dell'utente da validare
     * @return boolean TRUE se tutti i dati sono stati validati, FALSE altrimenti.
     */
    public function validaDatiUtente($datiUtente) 
    {
        $this->setValidati(TRUE);
        foreach ($datiUtente as $chiave => $valore) 
        {
            $pattern = "";
            $stringaErrore = "";
            switch ($chiave) 
            {
                case 'nome':
                case 'cognome':
                    // scrivere quello che c'è da fare
                    $pattern = '/^[a-zA-Zàèìùò\s]{2,20}$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di caratteri. Minimo 2 e massimo 20";
                    break;
                
                case 'codiceFiscale':
                    $pattern = '/^[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}$/' ;
                    $stringaErrore = "Il " . $chiave .  " è una sequenza di alfanumerica del tipo DMRCLD89S42G438S ";
                    break;
                
                case 'indirizzo':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,30}$/' ;
                    $stringaErrore = "L'" . $chiave . " deve essere una sequenza di caratteri. Massimo 30";
                    break;
                
                case 'numeroCivico':
                    $pattern = '/^[0-9]{1,6}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere un numero";
                    break;
                
                case "CAP":
                    $pattern = '/^[0-9]{5}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere una sequenza di 5 numeri";
                    break;
                
                case "email":
                    $pattern = '/^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/';
                    $stringaErrore = "L'" . $chiave . "deve essere una sequenza del tipo mario.rossi@gmail.com";
                    break;
                
                case "username":
                    $pattern = '/^[0-9a-zA-Z\_\-]{2,15}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza alfanumerica";
                    break;
                
                case "passwordUtente":
                    $pattern = '/^(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})$/';
                    $stringaErrore = "La password deve contenere almeno un "
                            . "numero, una lettera maiusola, "
                            . "una minuscola e deve essere lunga minimo 6 e massimo 10 ";
                    break;
                
                default:
                    echo "c'è qualcosa di sbagliato UValidazione validaDatiUtente";
                    break;  
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->_validati;
    }
    
     /**
     * Metodo che permette la validazione dei dati di Log In
     * 
     * @access public
     * @param Array $datiLogIn Dati del log in da validare
     * @return boolean TRUE se tutti i dati sono stati validati, FALSE altrimenti.
     */
    public function validaDatiLogIn($datiLogIn) 
    {
        $this->setValidati(TRUE);
        foreach ($datiLogIn as $chiave => $valore) 
        {
            $pattern = "";
            $stringaErrore = "";
            switch ($chiave) 
            {
                case "username":
                    $pattern = '/^[0-9a-zA-Z\_\-]{2,15}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza alfanumerica";
                    break;
                
                case "password":
                    $pattern = '/^(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})$/';
                    $stringaErrore = "La password deve contenere almeno un "
                            . "numero, una lettera maiusola, "
                            . "una minuscola e deve essere lunga minimo 6 e massimo 10 ";
                    break;
                
                default:
                    echo "c'è qualcosa di sbagliato UValidazione validaDatiLogIn";
                    break;  
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->_validati;
    }
    
    /**
     * Metodo che permette la validazione di tutti i dati del medico
     * 
     * @access public
     * @param Array $datiMedico Dati del medico da validare
     * @return boolean TRUE se tutti i dati sono stati validati, FALSE altrimenti.
     */
    public function validaDatiMedico($datiMedico) 
    {
        $this->setValidati(TRUE);
        foreach ($datiMedico as $chiave => $valore) 
        {
            $pattern = "";
            $stringaErrore = "";
            switch ($chiave) 
            {
                case 'nome':
                case 'cognome':
                    $pattern = '/^[a-zA-Zàèìùò\s]{2,20}$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di caratteri. Minimo 2 e massimo 20";
                    break;
                
                case 'codiceFiscale':
                    $pattern = '/^[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}$/' ;
                    $stringaErrore = "Il codice fiscale è una sequenza di alfanumerica del tipo DMRCLD89S42G438S ";
                    break;
                
                case 'via':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,30}$/' ;
                    $stringaErrore = "La" . $chiave . " deve essere una sequenza di caratteri. Massimo 30";
                    break;
                
                case 'numeroCivico':
                    $pattern = '/^[0-9]{1,6}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere un numero";
                    break;
                
                case 'CAP':
                    $pattern = '/^[0-9]{5}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere una sequenza di 5 numeri";
                    break;
                
                case 'email':
                case 'PEC':
                    $pattern = '/^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/';
                    $stringaErrore = "La " . $chiave . " deve essere una sequenza del tipo mario.rossi@gmail.com";
                    break;
                
                case 'username':
                    $pattern = '/^[0-9a-zA-Z\_\-]{2,15}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza alfanumerica";
                    break;
                
                case 'password':
                    $pattern = '/^(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})$/';
                    $stringaErrore = "La password deve contenere almeno un "
                            . "numero, una lettera maiusola, "
                            . "una minuscola e deve essere lunga minimo 6 e massimo 10 ";
                    break;
                
                case 'provinciaAlbo':
                    $pattern = '/^[A-Z]{2}$/';
                    $stringaErrore = "La provincia dell'albo a cui si è iscritti deve essere del tipo PE";
                    break;
                
                case 'numeroIscrizione':
                    $pattern = '/^[0-9]{6}$/';
                    $stringaErrore = "Il numero di iscrizione all'albo deve essere una sequenza di 6 numeri ";
                    break;
                
                default:
                    echo "c'è qualcosa di sbagliato UValidazione validaDatiMedico";
                    break;   
            }
   
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->validati;
    }
    
    /**
     * Metodo che permette la validazione di tutti i dati dell'esame
     * 
     * @access public
     * @param Array $datiEsame Dati dell'esame da validare
     * @return boolean TRUE se tutti i dati sono stati validati, FALSE altrimenti.
     */
    public function validaDatiEsame($datiEsame) 
    {
        $this->setValidati(TRUE);
        foreach ($datiEsame as $chiave => $valore) 
        {
            $pattern = "";
            $stringaErrore = "";
            switch ($chiave) 
            {
                case 'nomeEsame':
                case 'medicoEsame':
                    // scrivere quello che c'è da fare
                    $pattern = '/^[a-zA-Zàèìùò\s]{2,20}$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di caratteri. Minimo 2 e massimo 20";
                    break;
                
                case 'categoriaEsame':
                    $pattern = '/^[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}$/' ;
                    $stringaErrore = "Il " . $chiave .  " è una sequenza di alfanumerica del tipo DMRCLD89S42G438S ";
                    break;
                
                case 'prezzoEsame':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,30}$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere un numero";
                    break;
                
                case 'durataEsame':
                    $pattern = '/(0?\d|1[0-2]):(0\d|[0-5]\d)';
                    $stringaErrore = "La " . $chiave . " deve essere una durata valida";
                    break;
                
                case "numPrestazioniSimultanee":
                    $pattern = '/^[0-9]{2}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere una sequenza di 2 numeri";
                    break;
                
                default:
                    echo "c'è qualcosa di sbagliato UValidazione validaDatiUtente";
                    break;  
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->validati;
    }
    
    /**
     * Metodo che permette la validazione di tutti i dati della clinica
     * 
     * @access public
     * @param Array $datiClinica Dati della clinica da validare
     * @return boolean TRUE se tutti i dati sono stati validati, FALSE altrimenti.
     */
    public function validaDatiClinica($datiClinica) 
    {
        $this->setValidati(TRUE);
        foreach ($datiClinica as $chiave => $valore) 
        {
            $pattern = "";
            $stringaErrore = "";
            switch ($chiave) 
            {
                case 'partitaIVA':
                    $pattern = '/^[0-9]{11}$/' ;
                    $stringaErrore = "La partita IVA deve essere una sequenza di 11 numeri";
                    break;
                
                case 'nomeClinica':
                    $pattern = '/^[a-z^[0-9a-zA-Zàèìùò\s]{1,20}$/' ;
                    $stringaErrore = "Il nome della clinica deve essere una sequenza di caratteri. Minimo 1 e massimo 20";
                    break;
                    
                case 'titolare':
                    // scrivere quello che c'è da fare
                    $pattern = '/^[a-zA-Zàèìùò\s]{2,50}$/' ;
                    $stringaErrore = "Il titolare della clinica deve essere una "
                            . "sequenza di caratteri del tipo Anna Di Matteo. "
                            . "Minimo 2 e massimo 50";
                    break;
                
                case 'via':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,30}$/' ;
                    $stringaErrore = "La" . $chiave . " deve essere una sequenza di caratteri. Massimo 30";
                    break;
                
                case 'numeroCivico':
                    $pattern = '/^[0-9]{1,6}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere un numero";
                    break;
                
                case 'cap':
                    $pattern = '/^[0-9]{5}$/';
                    $stringaErrore = "Il CAP deve essere una sequenza di 5 numeri";
                    break;
                
                case 'localitàClinica':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,40}$/';
                    $stringaErrore = "La località in cui si trova la clinica "
                            . "deve essere una sequenza di caratteri. "
                            . "Massimo 40 numero";
                    break;
                
                case 'provinciaClinica':
                    $pattern = '/^[A-Z\s]{1,20}$/';
                    $stringaErrore = "La provincia deve essere una sequenza di caratteri";
                    break;
                
                case 'email':
                case 'PEC':
                    $pattern = '/^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/';
                    $stringaErrore = "L'" . $chiave . "deve essere una sequenza del tipo mario.rossi@gmail.com";
                    break;
                
                case 'username':
                    $pattern = '/^[0-9a-zA-Z\_\-]{2,15}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza alfanumerica";
                    break;
                
                case 'password':
                    $pattern = '/^(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})$/';
                    $stringaErrore = "La password deve contenere almeno un "
                            . "numero, una lettera maiusola, "
                            . "una minuscola e deve essere lunga minimo 6 e massimo 10 ";
                    break;
                
                case 'telefono':
                    $pattern = '/^[0-9]{10}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza di numeri";
                    break;
                
                case 'capitaleSociale':
                    $pattern = '/^[0-9]{1,11}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza di numeri";
                    break;
                
                default:
                    echo "c'è qualcosa di sbagliato UValidazione validaDatiClinica";
                    break;
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->_validati;
    }
    
    
    
    /**
     * Metodo che permette di effettuare la validazione di un dato 
     * 
     * @access private
     * @param string $pattern Description
     * @param string $chiave  Description
     * @param string $valore Il valore da controllare
     * @param string $stringaErrore La stringa contenente l'errore 
     */
    private function validaDato($pattern, $chiave, $valore, $stringaErrore) 
    {
        echo ($chiave);
        if (preg_match($pattern, $valore)) 
        {
            echo ($valore);
            $this->_datiErrati[$chiave] = FALSE;
            $this->_datiValidi[$chiave] = $valore;
            echo "OK";
            echo ($this->getValidati());
        } 
        else
        {
            
            $this->datiErrati[$chiave] = $stringaErrore;
            echo ($this->datiErrati[$chiave]);
            echo "NO";
            $this->validati = FALSE;
            echo ($this->getValidati());
        }
    }
    
    public function validaDatiInformazioni($dati)
    {
        $this->setValidati(TRUE);
        foreach ($dati as $chiave => $valore) 
        {
            $pattern = "";
            $stringaErrore = "";
            switch ($chiave) 
            {
                case 'Via':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,30}$/' ;
                    $stringaErrore = "L'" . $chiave . " deve essere una sequenza di caratteri. Massimo 30";
                    break;

                case 'NumCivico':
                    $pattern = '/^[0-9]{1,6}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere un numero";
                    break;

                case "CAP":
                    $pattern = '/^[0-9]{5}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere una sequenza di 5 numeri";
                    break;

                default:
                        echo "c'è qualcosa di sbagliato UValidazione validaDatiClinica";
                        break;
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->_validati;
    }
}
