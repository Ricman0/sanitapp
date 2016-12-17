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
     * Metodo che permette la validazione di tutti i dati 
     * 
     * @access public
     * @param Array $dati Dati  da validare
     * @return boolean TRUE se tutti i dati sono stati validati, FALSE altrimenti.
     */
    public function validaDati($dati) 
    {
        $this->setValidati(TRUE);
        foreach ($dati as $chiave => $valore) 
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
                
                case 'codiceFiscale':
                    $pattern = '/^[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}$/' ;
                    $stringaErrore = "Il " . $chiave .  " è una sequenza di alfanumerica del tipo DMRCLD89S42G438S ";
                    break;
                
                case 'partitaIVA':
                    $pattern = '/^[0-9]{11}$/' ;
                    $stringaErrore = "La partita IVA deve essere una sequenza di 11 numeri";
                    break;
                
                case 'nome':
                case 'cognome':
                    // scrivere quello che c'è da fare
                    $pattern = '/^[a-zA-Zàèìùò\s]{2,20}$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di caratteri. Minimo 2 e massimo 20";
                    break;

                
                case 'indirizzo':
                case 'via':
                case 'Via':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,30}$/' ;
                    $stringaErrore = "L'" . $chiave . " deve essere una sequenza di caratteri. Massimo 30";
                    break;
                
                case 'numeroCivico':
                case 'NumCivico':
                    $pattern = '/^[0-9]{1,6}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere un numero";
                    break;
                
                case "CAP":
                case 'cap':
                    $pattern = '/^[0-9]{5}$/';
                    $stringaErrore = "Il" . $chiave . " deve essere una sequenza di 5 numeri";
                    break;
                
                case "email":
                case 'PEC':
                    $pattern = '/^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/';
                    $stringaErrore =  $chiave . " deve essere una sequenza del tipo mario.rossi@gmail.com";
                    break;                    
               
                case 'provinciaAlbo':
                    $pattern = '/^[A-Z]{2,22}$/';
                    $stringaErrore = "La provincia dell'albo a cui si è iscritti deve essere del tipo PESCARA";
                    break;
                
                case 'numeroIscrizione':
                    $pattern = '/^[0-9]{6}$/';
                    $stringaErrore = "Il numero di iscrizione all'albo deve essere una sequenza di 6 numeri ";
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
                
                case 'telefono':
                    $pattern = '/^[0-9]{10}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza di numeri";
                    break;
                
                case 'capitaleSociale':
                    $pattern = '/^[0-9]{1,11}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza di numeri";
                    break;
                
                default:
                    break;  
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->_validati;
    }
    
    
    /**
     * Metodo che consente di validare una stringa contenente data in formato YYYY-MM-DD e ora hh:mm
     * 
     * @access public
     * @param string $dataOra Data e ora da validare
     * @return boolean TRUE se la stringa valida, FALSE altrimenti.
     */
    public function validaDataOraString($dataOra) 
    {
        $this->setValidati(TRUE);
        $pattern = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}$/';
        $stringaErrore = "Data e ora non validi";
        $this->validaDato($pattern, 'DataOra', $dataOra, $stringaErrore);
        return $this->_validati;
        
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
                case 'nome':
                case 'medico':
                case 'descrizione':
                case 'categoria':
                    $pattern = '/^[a-zA-Zàèìùò\s]+$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di caratteri. Minimo 2 e massimo 20";
                    break;
                
                case 'prezzo':
                    $pattern = '/^[0-9]+$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere un numero";
                    break;
                
                case 'durata':
                    $pattern = '/^[0-2]{1}[0-9]{1}:([0-5]{1}[0-9]{1})$/';
                    $stringaErrore = "La " . $chiave . " deve essere una durata valida ";
                    break;
                
                case "numPrestazioniSimultanee":
                    $pattern = '/^[0-9]{0,2}$/';
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di massimo 2 numeri";
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
        if (preg_match($pattern, $valore)) 
        {
            // gli echo sono da eliminare, solo solo per un rapido debug
//            echo ($valore);
            $this->_datiErrati[$chiave] = FALSE;
            $this->_datiValidi[$chiave] = $valore;
//            echo "OK";
//            echo ($this->getValidati());
        } 
        else
        {
//            echo ($chiave);
//            echo ($stringaErrore);
            $this->_datiErrati[$chiave] = $stringaErrore;
//            echo ($this->datiErrati[$chiave]);
//            echo "NO";
            $this->_validati = FALSE;
//            echo ($this->getValidati());
        }
    }
    
    
    /**
     * Valida i dati del referto come la dimensione massima, il formato del file e controlla l'esistenza del file
     * @param array $datiDaValidare un array contenente i dati relativi al referto da validare
     * @return type
     */
    public function validaDatiReferto($datiDaValidare) {
        
        $this->_validati = TRUE;
        
        $maxsize = 2 * 2097152;
        $formatiAccettati = array('application/pdf');
        if (file_exists($datiDaValidare['path'])) {
            $this->_datiErrati['path'] = 'Il file esiste già. ';
            $this->_validati = FALSE;
        }

        if ($datiDaValidare['fileSize'] >= $maxsize) {
            $this->_datiErrati['maxSize'] = 'File troppo grande, dimensione massima 4 Mb. ';
            $this->_validati = FALSE;
        }        
        
        if ((!in_array($datiDaValidare['fileType'], $formatiAccettati)) && (!empty($datiDaValidare['fileType']))) {
            $this->_datiErrati['type'] = 'Tipo file non accettato. Inserire un PDF. ';
            $this->_validati = FALSE;
        }
        
        return $this->_validati;

    }
}