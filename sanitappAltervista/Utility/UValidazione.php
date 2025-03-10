<?php

/** 
 * La classe UValidazione consente di effettuare la validazione lato server 
 * dei dati immessi nella form.
 * 
 * @package Utility
 * @author Claudia Di Marco & Riccardo Mantini
 */

class UValidazione {
    
    /**
     * Array contenente tutti gli input giusti/validati .
     * 
     * @access private
     * @var array Array contenente tutti gli input validati
     */
    private $_datiValidi;
    
    /**
     * Array contenente tutti gli input sbagliati.
     * 
     * @access private
     * @var array Array contenente tutti gli input sbagliati 
     */
    private $_datiErrati;
    
    /**
     * Variabile booleana che permette di capire se i dati sono validi 
     * 
     * @access private
     * @var boolean TRUE i dati sono stati validati, FALSE altrimenti
     */
    private $_validati;
    
    /**
     * Costruttore della classe UValidazione.
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
     * Metodo che consente di conoscere i dati validati.
     * 
     * @access public
     * @return array I dati validi
     */
    public function getDatiValidi()                                             //controllato
    {
        return $this->_datiValidi;
    }
    
    /**
     * Metodo che consente di conoscere se i dati sono validati.
     * 
     * @access public
     * @return boolean TRUE dati validi, FALSE almeno un dato non era valido
     */
    public function getValidati()                                               //controllato
    {
        return $this->_validati;
    }
    
    /**
     * Metodo che consente di conoscere i dati che si sono rilevati errati
     * durante la validazione dei dati.
     * 
     * @access public
     * @return array I dati sbagliati
     */
    public function getDatiErrati() 
    {
        return $this->_datiErrati;
    }
   
    /**
     * Metodo che consente di impostare  $_validati a true.
     * 
     * @access private
     * @param boolean TRUE dati validi, FALSE almeno un dato non era valido
     */
    private function setValidati($validati) 
    {
        $this->_validati = $validati;
    }
    
    /**
     * Metodo che permette la validazione dei dati della registrazione.
     * 
     * @access public
     * @param array $dati Dati  da validare
     * @return boolean TRUE se tutti i dati sono stati validati, FALSE altrimenti.
     */
    public function validaDati($dati)                                           //controllato
    {
        $this->setValidati(TRUE);
        foreach ($dati as $chiave => $valore) 
        {
            $pattern = '/^.+$/';
            $stringaErrore = "";
            switch ($chiave) 
            {
                case "username":                
                    $pattern = '/^[0-9a-zA-Z\_\-\.\$]{4,15}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza alfanumerica";
                    break;
                
                case "password":
                case 'passwordUtente':
                case 'passwordMedico':
                case 'passwordClinica':
                    $pattern = '/^(((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,10})$/';
                    $stringaErrore = "La password deve contenere almeno un "
                            . "numero, una lettera maiusola, "
                            . "una minuscola e deve essere lunga minimo 6 e massimo 10 ";
                    break;
                
                case 'codiceFiscale':
                    $pattern = '/^[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z]{1}[0-9]{3}[a-zA-Z]{1}$/' ;
                    $stringaErrore = "Il " . $chiave .  " è una sequenza di alfanumerica del tipo DMRCLD89S42G438S ";
                    break;
                
                case 'partitaIVA':
                case 'partitaIva':
                    $pattern = '/^[0-9]{11}$/' ;
                    $stringaErrore = "La partita IVA deve essere una sequenza di 11 numeri";
                    break;
                
                case 'nome':
                case 'cognome':
                    $pattern = '/^[a-zA-Zàèìùò\-\.\s]{2,20}$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di caratteri. Minimo 2 e massimo 20";
                    break;
                
                case 'indirizzo':
                case 'via':
                case 'Via':
                    $pattern = '/^[.\'\/’\-a-zA-Zàèìùò\s]{1,30}$/' ;
                    $stringaErrore = "L'" . $chiave . " deve essere una sequenza di caratteri. Massimo 30";
                    break;
                
                case 'passwordDb':
                case 'passwordEmail':
                case 'userDb':
                case 'host':
                case 'smtp':
                    $pattern = '/^.*$/' ;
                    $stringaErrore = "L'" . $chiave . " deve essere una sequenza di caratteri.";
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
                case "emailAdmin":
                case 'PEC':
                case 'pec':
                      $pattern= "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";
//                    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
//                    $pattern = '/^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/';
                    $stringaErrore =  $chiave . " deve essere una sequenza del tipo mario.rossi@gmail.com";
                    break;                    
               
                case 'provinciaAlbo':
                    $pattern = '/^[a-zA-Z\-\s\'\/’]{1,22}$/';
                    $stringaErrore = "La provincia dell'albo a cui si è iscritti deve essere del tipo PESCARA";
                    break;
                
                case 'numeroIscrizioneAlbo':
                case 'numeroIscrizione':
                    $pattern = '/^[0-9]{6}$/';
                    $stringaErrore = "Il numero di iscrizione all'albo deve essere una sequenza di 6 numeri ";
                    break;
                
                case 'codiceConferma':
                    $pattern = '/^[a-zA-Z0-9]+$/';
                    $stringaErrore = "Il codice deve essere una sequenza alfanumerica";
                    break;
                
                case 'nomeClinica':
                    $pattern = '/^[a-z^[0-9a-zA-Zàèìùò\s]{1,20}$/' ;
                    $stringaErrore = "Il nome della clinica deve essere una sequenza di caratteri. Minimo 1 e massimo 20";
                    break;
                
                case 'titolareClinica':
                case 'titolare':
                    $pattern = '/^[a-zA-Zàèìùò\-\_\.\s\'\/’]{2,50}$/' ;
                    $stringaErrore = "Il titolare della clinica deve essere una "
                            . "sequenza di caratteri del tipo Anna Di Matteo. "
                            . "Minimo 2 e massimo 50";
                    break;
                
                case 'localita':
                case 'localitaClinica':
                    $pattern = '/^[a-zA-Zàèìùò\s]{1,40}$/';
                    $stringaErrore = "La localita in cui si trova la clinica "
                            . "deve essere una sequenza di caratteri. "
                            . "Massimo 40 numero";
                    break;
                
                case 'provincia':
                case 'provinciaClinica':
                    $pattern = '/^[a-zA-Z\-\s\'\/’]{1,22}$/';
                    $stringaErrore = "La provincia deve essere una sequenza di caratteri";
                    break;
                
                case 'telefono':
                    $pattern = '/^[0-9]{3,10}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza di numeri";
                    break;
                
                case 'capitaleSociale':
                    $pattern = '/^[0-9\.\,]{1,11}$/';
                    $stringaErrore = "Il" . $chiave . "deve essere una sequenza di numeri";
                    break;
                
                case 'confermato':
                case 'validato':
                case 'bloccato':
                    $pattern = '/^(true|false)$/';
                    $stringaErrore = $chiave . "deve essere true o false";
                    break;
                
                case 'tipoUser':
                    $pattern = '/^(medico|clinica|utente|amministratore|Medico|Clinica|Utente|Amministratore)$/';
                    $stringaErrore = $chiave . "deve essere true o false";
                    break;
                    
                
                default:
                    $this->_validati = FALSE;
                    break;  
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->_validati;
    }
    
    
    /**
     * Metodo che consente di validare una stringa contenente data in formato YYYY-MM-DD e ora hh:mm.
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
     * Metodo che consente di validare il working plan della clinica.
     * 
     * @param array $workingPlanArray Il working Plan della clinica
     * @return boolean TRUE se validato, FALSE altrimenti
     */
    public function validaWorkingPlan($workingPlanArray) {
        $this->setValidati(TRUE);
        $pattern = '/^[0-2]{1}[0-9]{1}:([0-5]{1}[0-9]{1})$/';
        $stringaErrore =  "Deve essere un tempo valido ";
        foreach ($workingPlanArray as $workingPlanGiorno) {
            $start = '';
            $end = '';
            $breakStart = '';
            $breakEnd = '';
            if(gettype($workingPlanGiorno)!== 'NULL') 
            {
                foreach ($workingPlanGiorno as $chiave => $valore) {
                    $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
                    if($valore!== NULL)
                    {
                        switch ($chiave)
                        {
                            case 'Start':

                                $start = strtotime($valore);
                                break;

                            case 'End':
                                $end = strtotime($valore);
                                break;

                            case 'BreakStart':
                                $breakStart = strtotime($valore);
                                break;

                            case 'BreakEnd':
                                $breakEnd = strtotime($valore);
                                break;
                        }
                    }
                    
                }
                
                if($this->getValidati() && !is_string($start) && !is_string($end) && !is_string($breakEnd) && !is_string($breakStart) )
                {
                    
                    if($breakStart < $start &&  $breakStart > $end) // start deve essere minore di breakStart e breakstart minore di end per essere valido
                    {
                        $this->setValidati(FALSE);
                    } 
                    if($this->getValidati() && $breakStart!=='' && $end!=='')
                    {
                        if($breakEnd < $breakStart &&  $breakEnd > $end) // breakEnd deve essere maggiore di breakStart e breakend minore di end per essere valido
                        {
                            $this->setValidati(FALSE);
                        } 
                    }
                }
                elseif($this->getValidati() && !is_string($start) && !is_string($end))
                {
                    if($end < $start) // start deve essere minore di end per essere valido
                    {
                        $this->setValidati(FALSE);
                    }
                    if((is_string($breakEnd) && !is_string($breakStart)) || (!is_string($breakEnd) && is_string($breakStart)) )
                    {
                        $this->setValidati(FALSE);
                    }
                }
                else
                {
                    $this->setValidati(FALSE);
                }
            }
        }
        return $this->_validati;
    }
    
 
    
    /**
     * Metodo che permette la validazione di tutti i dati dell'esame.
     * 
     * @access public
     * @param array $datiEsame Dati dell'esame da validare
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
                case 'medicoResponsabile':
                case 'categoria':
                    $pattern = '/^([a-zA-Zèéàòùì,-;\._:\/’]|\s)*$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di caratteri. Minimo 2 e massimo 20";
                    break;
                
                case 'descrizione':
                    $pattern = '/^([a-zA-Zèéàòùì,-;\'\._:\/’\(\)]|\s)*$/' ;
                    $stringaErrore = "La " . $chiave . " deve essere una sequenza di caratteri. Massimo 600";
                    break;
                
                case 'prezzo':
                    $pattern = '/^[0-9\.\,]+$/' ;
                    $stringaErrore = "Il " . $chiave . " deve essere un numero";
                    break;
                
                case 'durata':
                case 'durataEsame':
                    $pattern = '/^[0-2]{1}[0-9]{1}:([0-5]{1}[0-9]{1})$/';
                    $stringaErrore = "La " . $chiave . " deve essere una durata valida ";
                    break;
                
                case "numPrestazioniSimultanee":
                    $pattern = '/^[0-9]{0,2}$/';
                    $stringaErrore = "Il " . $chiave . " deve essere una sequenza di massimo 2 numeri";
                    break;
                
                case 'idClinica':
                    $pattern = '/^[0-9]{11}$/' ;
                    $stringaErrore = "La partita IVA deve essere una sequenza di 11 numeri";
                    break;
                
                case 'idEsame':
                    $pattern = '/^[a-zA-Z0-9]{24}$/';
                    $stringaErrore = "L'id dell'esame deve essere una stringa alfanumerica ";
                    break;
                    
                    
                default:
                    $this->_validati = FALSE;
                    break;  
            }
            $this->validaDato($pattern, $chiave, $valore, $stringaErrore);
        }
        return $this->_validati;
    }
    
    
   /**
     * Metodo che permette di effettuare la validazione di un dato.
     * 
     * @access private
     * @param string $pattern L'espressione regolare che il dato deve soddisfare
     * @param string $chiave  L'indice del dato da validare
     * @param string $valore Il valore da controllare
     * @param string $stringaErrore La stringa contenente l'errore 
     */
    private function validaDato($pattern, $chiave, $valore, $stringaErrore)     //controllato
    {
        
        if (preg_match($pattern, $valore)) 
        {
            $this->_datiErrati[$chiave] = FALSE;
            $this->_datiValidi[$chiave] = $valore;
        } 
        else
        {
            $this->_datiErrati[$chiave] = $stringaErrore;
            $this->_validati = FALSE;
        }
    }
    
    
    /**
     * Valida i dati del referto come la dimensione massima, il formato del file e controlla l'esistenza del file.
     * 
     * @access public
     * @param array $datiDaValidare un array contenente i dati relativi al referto da validare
     * @return boolean TRUE validati, FALSE altrimenti
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
    
    /**
     * Metodo che consente di validare il nome di una categoria.
     * 
     * @access public
     * @param string $nomeCategoria Il nome della categoria
     * @return boolean TRUE dato valido, FALSE altrimenti
     */
    public function validaCategoria($nomeCategoria) {
        // non l'ho inserito nelle funzioni generiche perchè non è un array
        $this->setValidati(TRUE);
        $pattern = '/^[a-zA-Zàèìùò\s]{0,30}$/' ;
        $stringaErrore = "La categoria deve essere una sequenza di caratteri. Massimo 30";
        $this->validaDato($pattern, 'categoria', $nomeCategoria, $stringaErrore);
        return $this->_validati;
    }
}